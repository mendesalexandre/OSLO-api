<?php

namespace App\Observers;

use App\Models\Transacao;
use App\Enums\TransacaoStatusEnum;
use App\Enums\TransacaoTipo;
use App\Enums\TransacaoTipoEnum;

class TransacaoObserver
{
    /**
     * Executado após criar uma transação
     */
    public function created(Transacao $transacao): void
    {
        // Se já foi criada como PAGA, atualiza o saldo do caixa
        if ($transacao->status === TransacaoStatusEnum::PAGO) {
            $this->atualizarSaldoCaixa($transacao);
        }
    }

    /**
     * Executado após atualizar uma transação
     */
    public function updated(Transacao $transacao): void
    {
        // Se mudou de PENDENTE para PAGO
        if ($transacao->isDirty('status') && $transacao->status === TransacaoStatusEnum::PAGO) {
            $this->validarLancamentoRetroativo($transacao);
            $this->atualizarSaldoCaixa($transacao);
        }

        // Se mudou de PAGO para CANCELADO
        if (
            $transacao->isDirty('status') &&
            $transacao->getOriginal('status') === TransacaoStatusEnum::PAGO->value &&
            $transacao->status === TransacaoStatusEnum::CANCELADO
        ) {
            $this->reverterSaldoCaixa($transacao);
        }

        // Se mudou o valor de uma transação PAGA
        if ($transacao->isDirty('valor_pago') && $transacao->status === TransacaoStatusEnum::PAGO) {
            $this->recalcularSaldoCaixa($transacao);
        }
    }

    /**
     * Executado após deletar uma transação
     */
    public function deleted(Transacao $transacao): void
    {
        // Se estava PAGA, reverte o saldo
        if ($transacao->status === TransacaoStatusEnum::PAGO) {
            $this->reverterSaldoCaixa($transacao);
        }
    }

    /**
     * Atualiza o saldo do caixa quando transação é paga
     */
    protected function atualizarSaldoCaixa(Transacao $transacao): void
    {
        $caixa = $transacao->caixa;

        if ($transacao->tipo === TransacaoTipoEnum::ENTRADA) {
            // Adiciona ao saldo
            $caixa->increment('saldo_atual', $transacao->totalPago());
        } else {
            // Subtrai do saldo
            $caixa->decrement('saldo_atual', $transacao->totalPago());
        }
    }

    /**
     * Reverte o saldo do caixa quando transação é cancelada ou deletada
     */
    protected function reverterSaldoCaixa(Transacao $transacao): void
    {
        $caixa = $transacao->caixa;

        if ($transacao->tipo === TransacaoTipoEnum::ENTRADA) {
            // Remove do saldo
            $caixa->decrement('saldo_atual', $transacao->getOriginal('valor_pago') ?? $transacao->valor_pago);
        } else {
            // Devolve ao saldo
            $caixa->increment('saldo_atual', $transacao->getOriginal('valor_pago') ?? $transacao->valor_pago);
        }
    }

    /**
     * Recalcula o saldo quando o valor da transação muda
     */
    protected function recalcularSaldoCaixa(Transacao $transacao): void
    {
        $caixa = $transacao->caixa;
        $valorAntigo = $transacao->getOriginal('valor_pago');
        $valorNovo = $transacao->valor_pago;
        $diferenca = $valorNovo - $valorAntigo;

        if ($transacao->tipo === TransacaoTipoEnum::ENTRADA) {
            $caixa->increment('saldo_atual', $diferenca);
        } else {
            $caixa->decrement('saldo_atual', $diferenca);
        }
    }

    /**
     * Valida e registra lançamentos retroativos
     */
    protected function validarLancamentoRetroativo(Transacao $transacao): void
    {
        $dataLancamento = $transacao->data_pagamento ?? now();
        $diasDiferenca = now()->diffInDays($dataLancamento, false);

        // Se for lançamento retroativo (data no passado)
        if ($diasDiferenca > 0) {
            \Log::warning('🚨 Lançamento Retroativo Detectado', [
                'transacao_id' => $transacao->id,
                'caixa_id' => $transacao->caixa_id,
                'caixa_nome' => $transacao->caixa->nome,
                'tipo' => $transacao->tipo->value,
                'valor' => $transacao->totalPago(),
                'data_pagamento' => $dataLancamento->format('d/m/Y'),
                'dias_retroativo' => $diasDiferenca,
                'usuario_id' => auth()->id() ?? $transacao->usuario_id,
                'usuario_nome' => auth()->user()->name ?? $transacao->usuario->name,
                'data_hora_lancamento' => now()->format('d/m/Y H:i:s'),
            ]);

            // Opcional: Adicionar flag na transação para rastreamento
            // $transacao->update(['is_retroativo' => true], ['timestamps' => false]);

            // Opcional: Notificar gestor via evento
            // event(new LancamentoRetroativoDetectado($transacao, $diasDiferenca));
        }
    }
}
