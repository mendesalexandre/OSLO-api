<?php

namespace App\Services;

use App\Models\Contrato;
use App\Models\ContratoExigencia;
use App\Models\Protocolo;
use Illuminate\Support\Facades\DB;

class ContratoService
{
    public function criar(Protocolo $protocolo, array $dados): Contrato
    {
        return DB::transaction(function () use ($protocolo, $dados) {
            $dados['protocolo_id'] = $protocolo->id;
            $dados['numero'] = Contrato::gerarNumero();
            $dados['ano'] = now()->year;
            $dados['usuario_id'] = $dados['usuario_id'] ?? auth('api')->id();
            $dados['matricula'] = $dados['matricula'] ?? $protocolo->matricula;
            $dados['data_entrada'] = $dados['data_entrada'] ?? now()->toDateString();

            $contrato = Contrato::create($dados);

            $contrato->registrarAndamento(
                'pendente',
                'Contrato criado',
                $contrato->usuario_id
            );

            return $contrato->fresh()->load(['protocolo', 'responsavel:id,nome']);
        });
    }

    public function atualizarStatus(Contrato $contrato, string $novoStatus, string $descricao, int $usuarioId): void
    {
        DB::transaction(function () use ($contrato, $novoStatus, $descricao, $usuarioId) {
            $contrato->registrarAndamento($novoStatus, $descricao, $usuarioId);
            $contrato->update(['status' => $novoStatus]);
        });
    }

    public function adicionarExigencia(Contrato $contrato, array $dados): ContratoExigencia
    {
        $dados['usuario_id'] = $dados['usuario_id'] ?? auth('api')->id();

        $exigencia = $contrato->exigencias()->create($dados);

        if ($contrato->status !== 'exigencia') {
            $this->atualizarStatus(
                $contrato,
                'exigencia',
                "Exigência criada: {$dados['descricao']}",
                $dados['usuario_id']
            );
        }

        return $exigencia->load(['usuario:id,nome']);
    }

    public function cumprirExigencia(ContratoExigencia $exigencia): void
    {
        $exigencia->update([
            'cumprida' => true,
            'data_cumprimento' => now()->toDateString(),
        ]);

        $contrato = $exigencia->contrato;

        if (!$contrato->temExigenciaPendente() && $contrato->status === 'exigencia') {
            $this->atualizarStatus(
                $contrato,
                'em_andamento',
                'Todas as exigências foram cumpridas',
                auth('api')->id()
            );
        }
    }

    public function concluir(Contrato $contrato, int $usuarioId): void
    {
        DB::transaction(function () use ($contrato, $usuarioId) {
            $contrato->update([
                'status' => 'concluido',
                'data_conclusao' => now()->toDateString(),
            ]);

            $contrato->registrarAndamento('concluido', 'Contrato concluído', $usuarioId);
        });
    }
}
