<?php

namespace App\Services;

use App\Models\Protocolo;
use App\Models\ProtocoloIsencao;
use App\Models\ProtocoloPagamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PagamentoService
{
    public function registrar(Protocolo $protocolo, array $dados): ProtocoloPagamento
    {
        $valorRestante = $protocolo->valorRestante();

        if ($dados['valor'] > $valorRestante) {
            throw ValidationException::withMessages([
                'valor' => ["O valor não pode ser maior que o restante (R$ {$valorRestante})."],
            ]);
        }

        return DB::transaction(function () use ($protocolo, $dados) {
            $dados['usuario_id'] = $dados['usuario_id'] ?? auth('api')->id();
            $dados['data_pagamento'] = $dados['data_pagamento'] ?? now();

            $pagamento = $protocolo->pagamentos()->create($dados);

            $protocolo->recalcularValores();

            return $pagamento->load(['formaPagamento', 'meioPagamento', 'usuario:id,nome']);
        });
    }

    public function estornar(ProtocoloPagamento $pagamento, string $motivo): void
    {
        DB::transaction(function () use ($pagamento, $motivo) {
            $pagamento->update([
                'status' => 'estornado',
                'observacao' => ($pagamento->observacao ? $pagamento->observacao . ' | ' : '') . "Estorno: {$motivo}",
            ]);

            $pagamento->protocolo->recalcularValores();
        });
    }

    public function registrarIsencao(Protocolo $protocolo, array $dados): ProtocoloIsencao
    {
        return DB::transaction(function () use ($protocolo, $dados) {
            $dados['usuario_id'] = $dados['usuario_id'] ?? auth('api')->id();

            $isencao = $protocolo->isencoes()->create($dados);

            $protocolo->recalcularValores();

            return $isencao->load(['usuario:id,nome']);
        });
    }
}
