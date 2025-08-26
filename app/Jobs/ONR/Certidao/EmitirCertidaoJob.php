<?php

namespace App\Jobs\ONR\Certidao;

use App\DTOs\ONR\Certidao\CertidaoSolicitacaoDTO;
use App\Models\ONR\Certidao;
use App\Services\Lacuna\Assinador;
use App\Services\Lacuna\Certificado;
use App\Services\PDF\PDFService;
use App\Enums\ONRStatusEnum;
use App\Models\ONRConfiguracao;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class EmitirCertidaoJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 1800;
    public int $tries = 2;

    public function __construct(
        public readonly array $certidaoData
    ) {}

    public function handle(): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        // Configurações de memória e tempo
        ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 900);
        set_time_limit(900);

        $solicitacaoDTO = CertidaoSolicitacaoDTO::fromArray($this->certidaoData);
        Log::info("🚀 [STEP 3/3] Emitindo certidão: {$solicitacaoDTO->protocoloSolicitacao}");

        try {
            $certidao = Certidao::where('protocolo_solicitacao', $solicitacaoDTO->protocoloSolicitacao)->first();

            if (!$certidao) {
                throw new \Exception("Certidão não encontrada na base de dados");
            }

            // Verificar se passou pela validação
            if ($certidao->status_validacao !== ONRStatusEnum::VALIDADA->value) {
                Log::warning("⚠️ [STEP 3/3] Certidão não foi validada, pulando emissão: {$solicitacaoDTO->protocoloSolicitacao}");
                return;
            }

            // Atualizar para emitindo
            $this->atualizarStatusBatch(ONRStatusEnum::EMITINDO, 'Processando emissão da certidão', $solicitacaoDTO->protocoloSolicitacao);

            // Verificar se já foi processada
            if (in_array($certidao->status_envio, [
                ONRStatusEnum::ENVIADO_E_FINALIZADO->value,
                ONRStatusEnum::DEVOLVIDA_AUTOMATICAMENTE->value
            ])) {
                Log::info("ℹ️ [STEP 3/3] Certidão já foi processada: {$solicitacaoDTO->protocoloSolicitacao}");
                return;
            }

            // Ambiente local - simular processamento
            if (app()->environment('local')) {
                $this->simularProcessamentoLocal($certidao, $solicitacaoDTO);
                return;
            }

            // Processar emissão real
            $this->processarEmissaoReal($certidao, $solicitacaoDTO);
        } catch (\Throwable $e) {
            $this->tratarErroEmissao($e, $solicitacaoDTO);
            throw $e;
        }
    }

    private function simularProcessamentoLocal(Certidao $certidao, CertidaoSolicitacaoDTO $solicitacaoDTO): void
    {
        Log::info("🧪 [STEP 3/3] Simulando emissão em ambiente local: {$solicitacaoDTO->protocoloSolicitacao}");

        // Obter número da matrícula
        $numeroMatricula = $solicitacaoDTO->certidao->getNumeroMatricula();

        if (!$numeroMatricula) {
            throw new \Exception("Número da matrícula não encontrado na certidão");
        }

        // 1. Encontrar arquivo TIFF
        $tiffPath = $this->encontrarArquivoTiff($numeroMatricula);

        if (!$tiffPath) {
            throw new \Exception("Arquivo TIFF não encontrado para matrícula {$numeroMatricula}");
        }

        // 2. Verificar tamanho do arquivo
        $fileSize = File::size($tiffPath);
        Log::info("📁 Tamanho do arquivo TIFF: " . $this->formatBytes($fileSize));

        if ($fileSize > 100 * 1024 * 1024) { // > 100MB
            Log::warning("⚠️ Arquivo muito grande, processamento pode demorar");
        }

        $certidao->update(['tamanho_arquivo_mb' => round($fileSize / 1024 / 1024, 2)]);

        // 3. Converter TIFF para PDF
        Log::info("🔄 Convertendo TIFF para PDF...");
        $pdfParaAssinar = PDFService::converterTiffParaPdf($tiffPath, 'documentos/protegido', $certidao->toArray());

        // 4. Assinar PDF com certificado digital
        Log::info("✍️ Assinando PDF com certificado digital...");
        $nomeArquivoAssinar = $certidao->protocolo_solicitacao . '_' . $numeroMatricula . '_assinado.pdf';

        $certificadoId = ONRConfiguracao::query()->first()->certificado_digital_id;

        if (!$certificadoId) {
            throw new \Exception("Certificado digital não encontrado");
        }

        $certificado = new Certificado();
        $certificado = $certificado->carregarCertificado($certificadoId);
        $assinador = new Assinador($certificado);

        try {
            $arquivoAssinado = $assinador->assinar($pdfParaAssinar, $nomeArquivoAssinar);

            Log::info("✅ PDF assinado com sucesso:", [
                'arquivo_id' => $arquivoAssinado['id'] ?? null,
                'nome_arquivo' => $arquivoAssinado['signedFile']['name'] ?? null,
                'chave_formatada' => $arquivoAssinado['formattedKey'],
            ]);
        } catch (\Exception $e) {
            Log::error("❌ Erro na assinatura digital: " . $e->getMessage());
            throw new \Exception("Falha na assinatura digital: " . $e->getMessage());
        }

        $certidao->update([
            'status_envio' => ONRStatusEnum::SIMULADA->value,
            'mensagem_erro_envio' => 'Emissão simulada em ambiente local',
            'processada_em' => now(),
            'job_disparado_em' => now(),
            'onr_arquivo_assinado_web_id' => $arquivoAssinado['id'],
            'chave_formatada' => $arquivoAssinado['formattedKey'],
            'onr_nome_arquivo' => $arquivoAssinado['signedFile']['name'],
        ]);

        $this->atualizarStatusBatch(ONRStatusEnum::SIMULADA, 'Emissão simulada (ambiente local)', $solicitacaoDTO->protocoloSolicitacao);
        Log::info("✅ [STEP 3/3] Simulação concluída: {$solicitacaoDTO->protocoloSolicitacao}");
    }

    private function processarEmissaoReal(Certidao $certidao, CertidaoSolicitacaoDTO $solicitacaoDTO): void
    {
        // Obter número da matrícula
        $numeroMatricula = $solicitacaoDTO->certidao->getNumeroMatricula();

        if (!$numeroMatricula) {
            throw new \Exception("Número da matrícula não encontrado na certidão");
        }

        // 1. Encontrar arquivo TIFF
        $tiffPath = $this->encontrarArquivoTiff($numeroMatricula);

        if (!$tiffPath) {
            throw new \Exception("Arquivo TIFF não encontrado para matrícula {$numeroMatricula}");
        }

        // 2. Verificar tamanho do arquivo
        $fileSize = File::size($tiffPath);
        Log::info("📁 Tamanho do arquivo TIFF: " . $this->formatBytes($fileSize));

        if ($fileSize > 100 * 1024 * 1024) { // > 100MB
            Log::warning("⚠️ Arquivo muito grande, processamento pode demorar");
        }

        $certidao->update(['tamanho_arquivo_mb' => round($fileSize / 1024 / 1024, 2)]);

        // 3. Converter TIFF para PDF
        Log::info("🔄 Convertendo TIFF para PDF...");
        $pdfParaAssinar = PDFService::converterTiffParaPdf($tiffPath, 'documentos/protegido', $certidao->toArray());

        // 4. Assinar PDF com certificado digital
        Log::info("✍️ Assinando PDF com certificado digital...");
        $nomeArquivoAssinar = $certidao->protocolo_solicitacao . '_' . $numeroMatricula . '_assinado.pdf';

        $certificado = new Certificado();
        $assinador = new Assinador($certificado);

        try {
            $arquivoAssinado = $assinador->assinar($pdfParaAssinar, $nomeArquivoAssinar);

            Log::info("✅ PDF assinado com sucesso:", [
                'arquivo_id' => $arquivoAssinado['id'] ?? null,
                'nome_arquivo' => $arquivoAssinado['signedFile']['name'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error("❌ Erro na assinatura digital: " . $e->getMessage());
            throw new \Exception("Falha na assinatura digital: " . $e->getMessage());
        }

        // 5. Atualizar dados do arquivo assinado
        $certidao->update([
            'status_envio' => 'PDF_GERADO',
            'ultima_tentativa_envio' => now(),
            'onr_arquivo_assinado_web_id' => $arquivoAssinado['id'] ?? null,
            'onr_nome_arquivo' => $arquivoAssinado['signedFile']['name'] ?? null,
            'mensagem_erro_envio' => null,
            'onr_caminho_arquivo_assinado' => $arquivoAssinado['signedFile']['path'] ?? null,
            'pdf_gerado_em' => now(),
        ]);

        Log::info("📋 PDF gerado e assinado com sucesso");

        // 6. Disparar job de envio
        try {
            // Assumindo que existe um EnviarCertidaoJob
            // EnviarCertidaoJob::dispatch($certidao);

            Log::info("📤 Job de envio seria disparado para: {$solicitacaoDTO->protocoloSolicitacao}");

            $certidao->update([
                'status_envio' => 'ENVIO_JOB_DISPARADO',
                'mensagem_erro_envio' => 'Job de envio disparado com sucesso em ' . now()->format('Y-m-d H:i:s'),
                'job_disparado_em' => now()
            ]);

            $this->atualizarStatusBatch(ONRStatusEnum::ENVIADO_AO_CLIENTE, 'Certidão enviada para o cliente', $solicitacaoDTO->protocoloSolicitacao);
            Log::info("✅ [STEP 3/3] Emissão concluída: {$solicitacaoDTO->protocoloSolicitacao}");
        } catch (\Exception $e) {
            Log::error("❌ Erro ao disparar job de envio: " . $e->getMessage());

            $certidao->update([
                'status_envio' => 'ERRO_ENVIO_JOB',
                'mensagem_erro_envio' => 'Erro ao disparar job de envio: ' . $e->getMessage(),
                'ultima_tentativa_envio' => now()
            ]);

            throw new \Exception("Erro ao disparar job de envio: " . $e->getMessage());
        }
    }

    private function encontrarArquivoTiff(string $matricula): ?string
    {
        $basePath = ONRConfiguracao::query()
            ->where('diretorio_imagem_tiff', '!=', null)
            ->value('diretorio_imagem_tiff');

        if (!$basePath) {
            Log::error("Configuração de diretório TIFF não encontrada");
            return null;
        }

        $extensoes = ['tif', 'tiff', 'TIF', 'TIFF'];

        foreach ($extensoes as $ext) {
            $path = "{$basePath}/{$matricula}.{$ext}";
            Log::info("🔍 Procurando arquivo TIFF em: {$path}");

            if (File::exists($path)) {
                Log::info("✅ Arquivo TIFF encontrado: {$path}");
                return $path;
            }
        }

        Log::warning("❌ Arquivo TIFF não encontrado para matrícula: {$matricula}");
        return null;
    }

    private function atualizarStatusBatch(ONRStatusEnum $status, string $mensagem, string $protocolo): void
    {
        Certidao::where('protocolo_solicitacao', $protocolo)
            ->update([
                'status_batch' => $status->value,
                'mensagem_batch' => $mensagem,
                'data_alteracao' => now(),
            ]);
    }

    private function tratarErroEmissao(\Throwable $e, CertidaoSolicitacaoDTO $solicitacaoDTO): void
    {
        Log::error("❌ [STEP 3/3] Erro na emissão: {$solicitacaoDTO->protocoloSolicitacao} - {$e->getMessage()}");

        $certidao = Certidao::where('protocolo_solicitacao', $solicitacaoDTO->protocoloSolicitacao)->first();

        if ($certidao) {
            $certidao->increment('tentativas_envio');
            $certidao->update([
                'status_envio' => ONRStatusEnum::ERRO_EMISSAO->value,
                'mensagem_erro_envio' => $e->getMessage(),
                'ultima_tentativa_envio' => now(),
            ]);
        }

        $this->atualizarStatusBatch(ONRStatusEnum::ERRO_EMISSAO, "Erro na emissão: {$e->getMessage()}", $solicitacaoDTO->protocoloSolicitacao);
    }

    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    public function failed(\Throwable $exception): void
    {
        $solicitacaoDTO = CertidaoSolicitacaoDTO::fromArray($this->certidaoData);

        Log::error("💥 [STEP 3/3] Falha definitiva na emissão: {$solicitacaoDTO->protocoloSolicitacao} - {$exception->getMessage()}");

        $certidao = Certidao::where('protocolo_solicitacao', $solicitacaoDTO->protocoloSolicitacao)->first();

        if ($certidao) {
            $certidao->update([
                'status_envio' => ONRStatusEnum::FALHA_EMISSAO->value,
                'mensagem_erro_envio' => 'Falha definitiva: ' . $exception->getMessage(),
                'ultima_tentativa_envio' => now()
            ]);
        }

        $this->atualizarStatusBatch(ONRStatusEnum::FALHA_EMISSAO, "Falha definitiva: {$exception->getMessage()}", $solicitacaoDTO->protocoloSolicitacao);
    }
}
