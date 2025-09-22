<?php

namespace App\Jobs\ONR\Certidao;

use App\Models\ONR\Certidao;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessarTodasCertidoesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly array $certidoesData,
        public readonly ?string $usuarioId = null
    ) {}

    public function handle(): void
    {
        // Debug: verificar estrutura dos dados
        Log::info("📥 Dados recebidos no ProcessarTodasCertidoesJob:", [
            'total_certidoes' => count($this->certidoesData),
            'primeira_certidao_keys' => !empty($this->certidoesData) ? array_keys($this->certidoesData[0]) : []
        ]);

        if (empty($this->certidoesData)) {
            Log::info('Nenhuma certidão para processar');
            return;
        }

        Log::info("🚀 Iniciando processamento de " . count($this->certidoesData) . " certidões");

        // Criar um job individual para cada certidão usando dados originais
        foreach ($this->certidoesData as $index => $certidaoData) {
            // Verificar se os dados da certidão estão corretos
            if (!isset($certidaoData['PROTOCOLO_SOLICITACAO'])) {
                Log::error("Certidão no índice {$index} não tem PROTOCOLO_SOLICITACAO:", $certidaoData);
                continue;
            }

            // Atualizar status inicial
            Certidao::where('protocolo_solicitacao', $certidaoData['PROTOCOLO_SOLICITACAO'])
                ->update([
                    'status_batch' => 'INICIADO',
                    'mensagem_batch' => 'Processamento iniciado',
                    'iniciado_em' => now(),
                ]);

            // Disparar job individual com dados originais
            ProcessarCertidaoIndividualJob::dispatch($certidaoData, $this->usuarioId)
                ->onQueue('onr-certidao');

            Log::info("📤 Job individual disparado para: {$certidaoData['PROTOCOLO_SOLICITACAO']}");
        }

        Log::info("✅ Todos os jobs individuais foram disparados");
    }
}
