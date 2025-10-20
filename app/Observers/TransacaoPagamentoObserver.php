<?php

namespace App\Observers;

use App\Models\TransacaoPagamento;

class TransacaoPagamentoObserver
{
    /**
     * Executado após criar um pagamento
     */
    public function created(TransacaoPagamento $pagamento): void
    {
        /** @var TransacaoPagamento $pagamento */
        // Se o pagamento já foi marcado como pago na criação
        if ($pagamento->is_pago) {
            $pagamento->transacao->verificarStatusPagamento();
        }
    }

    /**
     * Executado após atualizar um pagamento
     */
    public function updated(TransacaoPagamento $pagamento): void
    {
        // Se mudou o status de is_pago
        if ($pagamento->isDirty('is_pago') && $pagamento->is_pago) {
            $pagamento->transacao->verificarStatusPagamento();
        }

        // Se mudou o valor_pago
        if ($pagamento->isDirty('valor_pago') && $pagamento->is_pago) {
            $pagamento->transacao->verificarStatusPagamento();
        }
    }

    /**
     * Executado após deletar um pagamento
     */
    public function deleted(TransacaoPagamento $pagamento): void
    {
        // Recalcular status da transação
        $pagamento->transacao->verificarStatusPagamento();
    }
}
