<?php

// app/Jobs/ONR/ECertidao/ProcessarCertidaoBatchJob.php
namespace App\Jobs\ONR\Certidao;

use App\DTOs\ONR\ECertidao\CertidaoDTO;
use App\DTOs\ONR\ECertidao\CertidaoCollectionDTO;
use App\Services\ONR\ECertidaoService;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ProcessarCertidaoBatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly array $certidoesData,
        public readonly ?string $usuarioId = null
    ) {}

    public function handle(): void
    {
        $certidoesCollection = CertidaoCollectionDTO::fromArray(['PEDIDO_CERTIDAO' => $this->certidoesData]);

        if ($certidoesCollection->isEmpty()) {
            Log::info('Nenhuma certidão para processar no batch');
            return;
        }

        $jobs = [];

        // Criar jobs sequenciais para cada certidão
        foreach ($certidoesCollection->certidoes as $certidao) {
            // Job 1: Sincronização
            $jobs[] = new SincronizarCertidaoJob($certidao);

            // Job 2: Validação
            $jobs[] = new ValidarCertidaoJob($certidao);

            // Job 3: Processamento/Emissão
            $jobs[] = new EmitirCertidaoJob($certidao);
        }

        // Criar o batch
        $batch = Bus::batch($jobs)
            ->name('Processamento de Certidões ONR - ' . now()->format('d/m/Y H:i:s'))
            ->allowFailures()
            ->onConnection('redis')
            ->onQueue('onr-certidao')
            ->then(function (Batch $batch) {
                Log::info("Batch {$batch->id} concluído com sucesso");
                // Aqui você pode disparar eventos de conclusão
            })
            ->catch(function (Batch $batch, \Throwable $e) {
                Log::error("Erro no batch {$batch->id}: " . $e->getMessage());
                // Aqui você pode disparar eventos de erro
            })
            ->finally(function (Batch $batch) {
                Log::info("Batch {$batch->id} finalizado");
                // Limpeza final
            })
            ->dispatch();

        Log::info("Batch criado com ID: {$batch->id} para {$certidoesCollection->count()} certidões");
    }
}
