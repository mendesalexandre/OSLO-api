<?php

namespace App\Jobs\ONR\Certidao;

use App\DTOs\ONR\Certidao\CertidaoSolicitacaoDTO;
use App\Enums\ONRStatusEnum;
use App\Models\ONR\Certidao;
use App\Models\ONRConfiguracao;
use App\Services\ONR\Certidao\CertidaoService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ValidarCertidaoJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries = 2;

    public function __construct(
        public readonly array $certidaoData
    ) {}

    public function handle(): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $solicitacaoDTO = CertidaoSolicitacaoDTO::fromArray($this->certidaoData);
        Log::info("🔍 [STEP 2/3] Validando certidão: {$solicitacaoDTO->protocoloSolicitacao}");

        try {
            $this->atualizarStatusBatch(ONRStatusEnum::VALIDANDO, 'Validando dados da certidão', $solicitacaoDTO->protocoloSolicitacao);

            $certidao = Certidao::where('protocolo_solicitacao', $solicitacaoDTO->protocoloSolicitacao)->first();

            if (!$certidao) {
                throw new \Exception("Certidão não encontrada na base de dados");
            }

            // Verificar horário comercial
            if (!$this->isHorarioComercial()) {
                $this->atualizarStatusBatch(ONRStatusEnum::AGUARDANDO_HORARIO, 'Aguardando horário comercial', $solicitacaoDTO->protocoloSolicitacao);
                Log::info("⏰ [STEP 2/3] Aguardando horário comercial: {$solicitacaoDTO->protocoloSolicitacao}");
                return;
            }

            // Validar se é certidão elegível para processamento
            if (!$this->validarTipoCertidao($solicitacaoDTO)) {
                $this->atualizarStatusBatch(ONRStatusEnum::TIPO_NAO_ELEGIVEL, 'Tipo de certidão não elegível para processamento automático', $solicitacaoDTO->protocoloSolicitacao);
                Log::warning("⚠️ [STEP 2/3] Tipo não elegível: {$solicitacaoDTO->protocoloSolicitacao}");
                return;
            }

            // Validar arquivo TIFF se necessário
            $numeroMatricula = $solicitacaoDTO->certidao->getNumeroMatricula();
            if ($numeroMatricula && !$this->validarArquivoTiff($numeroMatricula)) {
                $this->atualizarStatusBatch(ONRStatusEnum::ARQUIVO_TIFF_NAO_ENCONTRADO, "Arquivo TIFF não encontrado para matrícula {$numeroMatricula}", $solicitacaoDTO->protocoloSolicitacao);

                // Devolver certidão automaticamente
                // $this->devolverCertidao($certidao, $numeroMatricula);
                Log::warning("📁 [STEP 2/3] TIFF não encontrado: {$solicitacaoDTO->protocoloSolicitacao}");
                return;
            }

            // Validações adicionais
            $this->validarDadosObrigatorios($solicitacaoDTO);

            // Marcar como validada
            $certidao->update([
                'status_validacao' => ONRStatusEnum::VALIDADA->value,
                'mensagem_validacao' => 'Certidão validada com sucesso',
                'validada_em' => now()
            ]);

            $this->atualizarStatusBatch(ONRStatusEnum::VALIDADA, 'Certidão validada com sucesso', $solicitacaoDTO->protocoloSolicitacao);
            Log::info("✅ [STEP 2/3] Validação concluída: {$solicitacaoDTO->protocoloSolicitacao}");
        } catch (\Throwable $e) {
            Log::error("❌ [STEP 2/3] Erro na validação: {$solicitacaoDTO->protocoloSolicitacao} - {$e->getMessage()}");

            // Atualizar certidão com erro
            if (isset($certidao)) {
                $certidao->update([
                    'status_validacao' => ONRStatusEnum::ERRO_VALIDACAO->value,
                    'mensagem_validacao' => $e->getMessage()
                ]);
            }

            $this->atualizarStatusBatch(ONRStatusEnum::ERRO_VALIDACAO, "Erro na validação: {$e->getMessage()}", $solicitacaoDTO->protocoloSolicitacao);
            throw $e;
        }
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

    private function validarTipoCertidao(CertidaoSolicitacaoDTO $solicitacaoDTO): bool
    {
        // Verificar se é certidão de imóvel (tipo 3) e pedido por matrícula (tipo 4)
        return $solicitacaoDTO->certidao->isCertidaoImovel() &&
            $solicitacaoDTO->certidao->isPedidoPorMatricula();
    }

    private function validarArquivoTiff(string $matricula): bool
    {
        $basePath = ONRConfiguracao::query()
            ->value('diretorio_imagem_tiff');

        if (!$basePath) {
            Log::warning("Configuração de diretório TIFF não encontrada");
            return false;
        }

        $extensoes = ['tif', 'tiff', 'TIF', 'TIFF'];

        foreach ($extensoes as $ext) {
            $path = "{$basePath}/{$matricula}.{$ext}";
            if (File::exists($path)) {
                Log::info("📁 Arquivo TIFF encontrado: {$path}");
                return true;
            }
        }

        Log::warning("📁 Arquivo TIFF não encontrado para matrícula: {$matricula}");
        return false;
    }

    private function devolverCertidao(Certidao $certidao, string $numeroMatricula): void
    {
        try {
            (new CertidaoService)->devolverCertidao([
                'Protocolo' => $certidao->protocolo_solicitacao,
                'Motivo' => "Prezado cliente, a matrícula informada {$numeroMatricula} não foi encontrada. Por favor, verifique a matrícula informada e tente novamente."
            ]);

            $certidao->update([
                'status_envio' => ONRStatusEnum::DEVOLVIDA_AUTOMATICAMENTE->value,
                'devolvida_em' => now()
            ]);

            Log::info("📤 Certidão {$certidao->protocolo_solicitacao} devolvida automaticamente");
        } catch (\Exception $e) {
            Log::error("Erro ao devolver certidão automaticamente: " . $e->getMessage());
        }
    }

    private function validarDadosObrigatorios(CertidaoSolicitacaoDTO $solicitacaoDTO): void
    {
        if (empty($solicitacaoDTO->solicitante->nome)) {
            throw new \Exception("Nome do solicitante é obrigatório");
        }

        if (empty($solicitacaoDTO->solicitante->cpfCnpj)) {
            throw new \Exception("CPF/CNPJ do solicitante é obrigatório");
        }
    }

    private function isHorarioComercial(): bool
    {
        $agora = now('America/Cuiaba');
        $diaSemana = $agora->format('N');

        // Se for sábado (6) ou domingo (7), não é horário comercial
        if ($diaSemana >= 6) {
            return false;
        }

        $horaInicial = ONRConfiguracao::query()
            ->value('atendimento_inicio') ?? '08:00';

        $horaFinal = ONRConfiguracao::query()
            ->value('atendimento_fim') ?? '17:00';

        Log::info("Horário comercial configurado: {$horaInicial} - {$horaFinal}");

        $hora = $agora->format('H:i');
        return $hora >= $horaInicial && $hora <= $horaFinal;
    }

    public function failed(\Throwable $exception): void
    {
        $solicitacaoDTO = CertidaoSolicitacaoDTO::fromArray($this->certidaoData);
        $this->atualizarStatusBatch(ONRStatusEnum::FALHA_VALIDACAO, "Falha definitiva: {$exception->getMessage()}", $solicitacaoDTO->protocoloSolicitacao);
        Log::error("💥 [STEP 2/3] Falha definitiva na validação: {$solicitacaoDTO->protocoloSolicitacao}");
    }
}
