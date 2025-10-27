<?php

namespace App\Services\Doi;

use App\Models\Doi;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use App\Jobs\Doi\DoiImportarSiteReceitaJob;

class DoiBatchService
{
    public function importarLote(array $doisData, string $nomeLote = ''): Batch
    {
        Log::info("🔄 Criando DOIs no banco antes de processar...");

        // PASSO 1: Criar todos os DOIs no banco primeiro com dados básicos
        $doisCriados = [];
        foreach ($doisData as $doiData) {
            $doi = Doi::query()->updateOrCreate(
                ['doi_importacao_id' => $doiData['id']],
                [
                    'numero_controle' => $doiData['numeroControle'],
                    'data_ato' => $doiData['dataLavraturaRegistroAverbacao'],
                    'data' => $doiData,
                    'matricula' => $doiData['matricula'],
                    'data_importacao' => now()->setTimezone('America/Cuiaba'),
                    'status_processamento' => 'pendente',
                    'status' => 'pendente',
                ]
            );

            $doisCriados[] = $doi;
        }

        Log::info("✅ " . count($doisCriados) . " Declarações criados no banco com dados básicos");

        // PASSO 2: Criar jobs para processar cada DOI (agora que já existem no banco)
        $jobs = collect($doisData)->map(function ($doiData) {
            return new DoiImportarSiteReceitaJob($doiData); // Passa dados originais
        })->toArray();

        $batch = Bus::batch($jobs)
            ->name($nomeLote ?? 'Importação DOI - ' . now()->format('d/m/Y H:i'))
            ->onConnection('redis')
            ->onQueue('doi-normal')
            ->allowFailures()
            ->then(function (Batch $batch) {
                Log::info("✅ Batch {$batch->name} completado!", [
                    'total' => $batch->totalJobs,
                    'processados' => $batch->processedJobs(),
                    'falhas' => $batch->failedJobs,
                ]);
            })
            ->catch(function (Batch $batch, \Throwable $e) {
                Log::error("❌ Batch {$batch->name} falhou!", [
                    'erro' => $e->getMessage(),
                    'falhas' => $batch->failedJobs,
                ]);
            })
            ->dispatch();

        Log::info("🚀 Batch iniciado: {$batch->name} com {$batch->totalJobs} jobs");

        return $batch;
    }

    public function statusBatch(string $batchId): array
    {
        $batch = Bus::findBatch($batchId);

        if (!$batch) {
            return ['erro' => 'Batch não encontrado'];
        }

        return [
            'id' => $batch->id,
            'nome' => $batch->name,
            'total_jobs' => $batch->totalJobs,
            'pendentes' => $batch->pendingJobs,
            'processados' => $batch->processedJobs(),
            'falhas' => $batch->failedJobs,
            'progresso' => $batch->progress(),
            'finalizado' => $batch->finished(),
            'cancelado' => $batch->cancelled(),
            'criado_em' => $batch->createdAt?->format('d/m/Y H:i:s'),
            'finalizado_em' => $batch->finishedAt?->format('d/m/Y H:i:s'),
        ];
    }

    public function listarBatchesAtivos(): array
    {
        return DB::table('job_batches')
            ->whereNull('finished_at')
            ->whereNull('cancelled_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($batch) {
                $batchObj = Bus::findBatch($batch->id);
                if (!$batchObj) {
                    return null;
                }

                return [
                    'id' => $batch->id,
                    'nome' => $batch->name,
                    'total_jobs' => $batchObj->totalJobs,
                    'pendentes' => $batchObj->pendingJobs,
                    'processados' => $batchObj->processedJobs(),
                    'falhas' => $batchObj->failedJobs,
                    'progresso' => $batchObj->progress(),
                    'finalizado' => $batchObj->finished(),
                    'cancelado' => $batchObj->cancelled(),
                    'criado_em' => $batchObj->createdAt?->format('d/m/Y H:i:s'),
                    'finalizado_em' => $batchObj->finishedAt?->format('d/m/Y H:i:s'),
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }

    public function cancelarBatch(string $batchId): bool
    {
        $batch = Bus::findBatch($batchId);

        if (!$batch) {
            return false;
        }

        $batch->cancel();
        Log::info("🛑 Batch {$batch->name} cancelado");

        return true;
    }
}
