<?php

namespace App\Jobs\ONR\Certidao;

use App\Services\ONR\Certidao\CertidaoService;
use App\Enums\ONRStatusEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class EnviarCertidaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3; // Máximo 3 tentativas
    public int $timeout = 120; // Timeout de 2 minutos
    public array $backoff = [60, 180, 300]; // Delay entre tentativas: 1min, 3min, 5min

    public function __construct(
        protected $pedido
    ) {}

    public function handle(): void
    {
        try {
            Log::info('📋 Iniciando processamento de envio de certidão', [
                'pedido_id' => $this->pedido->id ?? 'N/A',
                'protocolo' => $this->pedido->protocolo_solicitacao,
                'tentativa' => $this->attempts(),
                'data' => now()->format('Y-m-d H:i:s')
            ]);

            $certidaoService = new CertidaoService();
            $protocolo = $this->pedido->protocolo_solicitacao;

            // Determinar arquivo e caminho
            $nomeArquivo = $this->pedido->onr_nome_arquivo;
            $caminhoArquivo = storage_path('app/documentos/assinados/' . $nomeArquivo);

            // Verificar se arquivo existe
            if (!file_exists($caminhoArquivo)) {
                throw new \Exception("Arquivo não encontrado: {$caminhoArquivo}");
            }

            // Verificar tamanho do arquivo
            $tamanhoBytes = filesize($caminhoArquivo);
            $tamanhoMB = $tamanhoBytes / (1024 * 1024);
            $limiteBase64MB = 10; // 10MB limite para base64

            Log::info('📏 Informações do arquivo', [
                'arquivo' => $nomeArquivo,
                'tamanho_bytes' => $tamanhoBytes,
                'tamanho_mb' => round($tamanhoMB, 2),
                'metodo_envio' => $tamanhoMB > $limiteBase64MB ? 'DocumentID' : 'Base64'
            ]);

            // Atualizar status para enviando
            $this->pedido->update([
                'status_envio' => ONRStatusEnum::ENVIADO_AO_CLIENTE->value,
                'metodo_envio' => $tamanhoMB > $limiteBase64MB ? 'DocumentID' : 'Base64',
                'tamanho_arquivo_mb' => round($tamanhoMB, 2)
            ]);

            // 1º Passo: Enviar anexo - escolher método baseado no tamanho
            if ($tamanhoMB > $limiteBase64MB) {
                $resultadoAnexo = $this->enviarArquivoGrande($certidaoService, $protocolo, $tamanhoMB);
            } else {
                $resultadoAnexo = $this->enviarArquivoPequeno($certidaoService, $protocolo, $nomeArquivo, $caminhoArquivo, $tamanhoMB);
            }

            Log::info('📤 Resultado envio anexo:', (array) $resultadoAnexo);

            // Verificação: Anexo enviado com sucesso
            if ($resultadoAnexo->RETORNO === true) {
                $this->finalizarEnvio($certidaoService, $protocolo, $resultadoAnexo, $tamanhoMB, $limiteBase64MB);
            } else {
                throw new \Exception('Falha no envio do anexo: ' . ($resultadoAnexo->ERRODESCRICAO ?? 'Erro desconhecido'));
            }
        } catch (\Exception $e) {
            $this->tratarErroEnvio($e);
            throw $e;
        }
    }

    private function enviarArquivoGrande($certidaoService, string $protocolo, float $tamanhoMB): object
    {
        Log::info('📤 Arquivo grande detectado - usando método DocumentID', [
            'protocolo' => $protocolo,
            'tamanho_mb' => round($tamanhoMB, 2)
        ]);

        $documentID = $this->pedido->onr_arquivo_assinado_web_id;

        return $certidaoService->enviarAnexoCertidaoDocID([
            'Protocolo' => $protocolo,
            'DocumentID' => $documentID
        ]);
    }

    private function enviarArquivoPequeno($certidaoService, string $protocolo, string $nomeArquivo, string $caminhoArquivo, float $tamanhoMB): object
    {
        Log::info('📤 Arquivo pequeno - usando método Base64', [
            'protocolo' => $protocolo,
            'arquivo' => $nomeArquivo,
            'tamanho_mb' => round($tamanhoMB, 2)
        ]);

        return $certidaoService->enviarAnexoCertidao([
            'Protocolo' => $protocolo,
            'NomeArquivo' => $nomeArquivo,
            'ArquivoBase64' => base64_encode(file_get_contents($caminhoArquivo)),
        ]);
    }

    private function finalizarEnvio($certidaoService, string $protocolo, object $resultadoAnexo, float $tamanhoMB, float $limiteBase64MB): void
    {
        // Aguardar um pouco antes de finalizar
        Log::info('🏁 Anexo enviado com sucesso, aguardando antes de finalizar', [
            'protocolo' => $protocolo,
            'metodo_usado' => $tamanhoMB > $limiteBase64MB ? 'DocumentID' : 'Base64'
        ]);
        sleep(3);

        // 2º Passo: Finalizar protocolo
        Log::info('🏁 Iniciando finalização do protocolo', ['protocolo' => $protocolo]);

        try {
            $resultadoFinalizar = $certidaoService->finalizarRespostaCertidao([
                'Protocolo' => $protocolo,
                'Matriculas' => '',
                'InteresseSocial' => false,
            ]);

            Log::info('🏁 Resultado finalização:', (array) $resultadoFinalizar);

            // Sucesso completo
            $this->pedido->update([
                'status_envio' => ONRStatusEnum::ENVIADO_E_FINALIZADO->value,
                'status_batch' => ONRStatusEnum::ENVIADO_E_FINALIZADO->value,
                'mensagem_batch' => 'Certidão enviada e finalizada com sucesso',
                'mensagem_erro_envio' => null,
                'resultado_anexo' => json_encode($resultadoAnexo),
                'resultado_finalizacao' => json_encode($resultadoFinalizar),
                'ultima_tentativa_envio' => now(),
                'data_envio_sucesso' => now(),
                'metodo_envio_usado' => $tamanhoMB > $limiteBase64MB ? 'DocumentID' : 'Base64',
                'processada_em' => now(),
                'finalizado_em' => now(),
            ]);

            Log::info('✅ Certidão enviada e finalizada com sucesso', [
                'protocolo' => $protocolo,
                'pedido_id' => $this->pedido->id,
                'status_final' => ONRStatusEnum::ENVIADO_E_FINALIZADO->value,
                'metodo_usado' => $tamanhoMB > $limiteBase64MB ? 'DocumentID' : 'Base64'
            ]);
        } catch (\Exception $e) {
            Log::warning('⚠️ Anexo enviado com sucesso, mas erro na finalização', [
                'protocolo' => $protocolo,
                'erro_finalizacao' => $e->getMessage()
            ]);

            $this->pedido->update([
                'status_envio' => 'ANEXO_ENVIADO_ERRO_FINALIZACAO',
                'status_batch' => 'ANEXO_ENVIADO_ERRO_FINALIZACAO',
                'mensagem_batch' => 'Anexo enviado, erro na finalização',
                'mensagem_erro_envio' => 'Anexo enviado com sucesso. Erro na finalização: ' . $e->getMessage(),
                'resultado_anexo' => json_encode($resultadoAnexo),
                'resultado_finalizacao' => null,
                'ultima_tentativa_envio' => now(),
                'data_envio_sucesso' => now(),
                'metodo_envio_usado' => $tamanhoMB > $limiteBase64MB ? 'DocumentID' : 'Base64',
            ]);

            Log::info('⚠️ Processamento concluído com sucesso parcial', [
                'protocolo' => $protocolo,
                'status_final' => 'ANEXO_ENVIADO_ERRO_FINALIZACAO'
            ]);
        }
    }

    private function tratarErroEnvio(\Exception $e): void
    {
        Log::error('❌ Erro no processamento da certidão', [
            'pedido_id' => $this->pedido->id ?? 'N/A',
            'protocolo' => $this->pedido->protocolo_solicitacao,
            'erro' => $e->getMessage(),
            'tentativa' => $this->attempts(),
            'trace' => $e->getTraceAsString()
        ]);

        $this->pedido->update([
            'status_envio' => ONRStatusEnum::ERRO_EMISSAO->value,
            'status_batch' => ONRStatusEnum::ERRO_EMISSAO->value,
            'mensagem_batch' => 'Erro no envio (tentativa ' . $this->attempts() . ')',
            'mensagem_erro_envio' => 'Erro no envio (tentativa ' . $this->attempts() . '): ' . $e->getMessage(),
            'ultima_tentativa_envio' => now()
        ]);

        $this->pedido->increment('tentativas_envio');
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('💥 Job EnviarCertidaoJob falhou definitivamente', [
            'pedido_id' => $this->pedido->id ?? 'N/A',
            'protocolo' => $this->pedido->protocolo_solicitacao,
            'erro' => $exception->getMessage(),
            'tentativas_totais' => $this->attempts()
        ]);

        // Atualizar status final de falha
        $this->pedido->update([
            'status_envio' => ONRStatusEnum::FALHA_EMISSAO->value,
            'status_batch' => ONRStatusEnum::FALHA_EMISSAO->value,
            'mensagem_batch' => 'Falha definitiva após ' . $this->attempts() . ' tentativas',
            'mensagem_erro_envio' => 'Falha após ' . $this->attempts() . ' tentativas: ' . $exception->getMessage(),
            'ultima_tentativa_envio' => now(),
            'finalizado_em' => now(),
        ]);
    }
}
