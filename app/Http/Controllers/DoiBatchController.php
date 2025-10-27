<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;

class DoiBatchController extends Controller
{
    public function iniciarImportacao(Request $request, DoiBatchImportService $importService)
    {
        $request->validate([
            'dois' => 'required|array',
            'nome_lote' => 'nullable|string|max:255'
        ]);

        $batch = $importService->importarLote(
            $request->dois,
            $request->nome_lote
        );

        return response()->json([
            'batch_id' => $batch->id,
            'total_jobs' => $batch->totalJobs,
            'message' => 'Importação iniciada com sucesso!'
        ]);
    }

    public function statusBatch($batchId)
    {
        $batch = Bus::findBatch($batchId);

        if (!$batch) {
            return response()->json(['error' => 'Batch não encontrado'], 404);
        }

        return response()->json([
            'id' => $batch->id,
            'name' => $batch->name,
            'total_jobs' => $batch->totalJobs,
            'pending_jobs' => $batch->pendingJobs,
            'processed_jobs' => $batch->processedJobs(),
            'failed_jobs' => $batch->failedJobs,
            'progress' => $batch->progress(),
            'finished' => $batch->finished(),
            'cancelled' => $batch->cancelled(),
            'created_at' => $batch->createdAt,
            'finished_at' => $batch->finishedAt,
        ]);
    }

    public function listarBatches()
    {
        // Busca batches recentes (últimos 30 dias)
        $batches = DB::table('job_batches')
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($batch) {
                $batchObj = Bus::findBatch($batch->id);
                return [
                    'id' => $batch->id,
                    'name' => $batch->name,
                    'progress' => $batchObj ? $batchObj->progress() : 0,
                    'status' => $this->getBatchStatus($batch),
                    'created_at' => $batch->created_at,
                    'finished_at' => $batch->finished_at,
                ];
            });

        return response()->json($batches);
    }

    public function cancelarBatch($batchId)
    {
        $batch = Bus::findBatch($batchId);

        if (!$batch) {
            return response()->json(['error' => 'Batch não encontrado'], 404);
        }

        $batch->cancel();

        return response()->json(['message' => 'Batch cancelado com sucesso']);
    }

    private function getBatchStatus($batch): string
    {
        if ($batch->cancelled_at) return 'cancelled';
        if ($batch->finished_at) return 'finished';
        return 'processing';
    }
}
