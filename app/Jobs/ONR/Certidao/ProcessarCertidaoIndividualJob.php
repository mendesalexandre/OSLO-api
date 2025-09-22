<?php

namespace App\Jobs\ONR\Certidao;

use App\DTOs\ONR\Certidao\CertidaoSolicitacaoDTO;
use Illuminate\Bus\Batch;
use App\Models\ONR\Certidao;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\DTOs\ONR\ECertidao\CertidaoDTO;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\ONR\Certidao\EmitirCertidaoJob;
use App\Jobs\ONR\Certidao\ValidarCertidaoJob;
use App\Jobs\ONR\Certidao\SincronizarCertidaoJob;

class ProcessarCertidaoIndividualJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly array $certidaoData,
        public readonly ?string $usuarioId = null
    ) {}

    public function handle(): void
    {
        // Debug: verificar estrutura dos dados
        Log::info("📥 Dados recebidos no ProcessarCertidaoIndividualJob:", [
            'keys' => array_keys($this->certidaoData),
            'protocolo' => $this->certidaoData['PROTOCOLO_SOLICITACAO'] ?? 'NÃO ENCONTRADO'
        ]);

        // Verificar se tem a chave necessária
        if (!isset($this->certidaoData['PROTOCOLO_SOLICITACAO'])) {
            Log::error("PROTOCOLO_SOLICITACAO não encontrado nos dados:", $this->certidaoData);
            return;
        }

        try {
            $certidaoDTO = CertidaoSolicitacaoDTO::fromArray($this->certidaoData);
            Log::info("Criando batch individual para certidão: {$certidaoDTO->protocoloSolicitacao}");

            // Criar jobs sequenciais para esta certidão específica
            $jobs = [
                new SincronizarCertidaoJob($this->certidaoData),
                new ValidarCertidaoJob($this->certidaoData),
                new EmitirCertidaoJob($this->certidaoData),
            ];

            $batch = Bus::batch($jobs)
                ->name("Protocolo de Solicitação ONR: {$certidaoDTO->protocoloSolicitacao}")
                ->allowFailures(false)
                ->onConnection('redis')
                ->onQueue('onr-certidao')
                ->dispatch();

            Log::info("📋 Batch criado com ID: {$batch->id} para certidão: {$certidaoDTO->protocoloSolicitacao}");
        } catch (\Throwable $e) {
            Log::error("Erro ao criar DTO ou batch para certidão:", [
                'erro' => $e->getMessage(),
                'dados' => $this->certidaoData
            ]);
        }
    }

    private function getCertidaoFromBatch(Batch $batch): string
    {
        // Extrair protocolo do nome do batch
        return str_replace('Certidão: ', '', $batch->name);
    }

    private function atualizarStatusCertidao(string $protocolo, string $status, string $mensagem): void
    {
        try {
            Certidao::where('protocolo_solicitacao', $protocolo)
                ->update([
                    'status_batch' => $status,
                    'mensagem_batch' => $mensagem,
                    'finalizado_em' => now(),
                ]);
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar status da certidão: " . $e->getMessage());
        }
    }
}
