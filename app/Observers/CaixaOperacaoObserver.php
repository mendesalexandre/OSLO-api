<?php

namespace App\Observers;

use App\Models\CaixaOperacao;
use App\Enums\CaixaOperacaoTipoEnum;
use Illuminate\Support\Facades\Log;

class CaixaOperacaoObserver
{
    /**
     * Executado após criar uma operação
     */
    public function created(CaixaOperacao $operacao): void
    {
        $this->atualizarSaldoCaixa($operacao);
    }

    /**
     * Executado após atualizar uma operação
     */
    public function updated(CaixaOperacao $operacao): void
    {
        // Se mudou o valor, recalcular saldo
        if ($operacao->isDirty('valor')) {
            $this->recalcularSaldo($operacao);
        }
    }

    /**
     * Executado após deletar uma operação (estorno)
     */
    public function deleted(CaixaOperacao $operacao): void
    {
        $this->reverterSaldoCaixa($operacao);
    }

    /**
     * Atualiza o saldo do caixa quando operação é criada
     */
    protected function atualizarSaldoCaixa(CaixaOperacao $operacao): void
    {
        switch ($operacao->tipo) {
            case CaixaOperacaoTipoEnum::SANGRIA:
                // Remove do saldo
                $operacao->caixa->decrement('saldo_atual', $operacao->valor);

                \Log::info('💸 Sangria realizada', [
                    'operacao_id' => $operacao->id,
                    'caixa' => $operacao->caixa->nome,
                    'valor' => $operacao->valor,
                    'saldo_anterior' => $operacao->caixa->saldo_atual + $operacao->valor,
                    'saldo_atual' => $operacao->caixa->saldo_atual,
                ]);
                break;

            case CaixaOperacaoTipoEnum::REFORCO:
                // Adiciona no saldo
                $operacao->caixa->increment('saldo_atual', $operacao->valor);

                \Log::info('💰 Reforço realizado', [
                    'operacao_id' => $operacao->id,
                    'caixa' => $operacao->caixa->nome,
                    'valor' => $operacao->valor,
                    'saldo_anterior' => $operacao->caixa->saldo_atual - $operacao->valor,
                    'saldo_atual' => $operacao->caixa->saldo_atual,
                ]);
                break;

            case CaixaOperacaoTipoEnum::TRANSFERENCIA:
                // Remove do caixa origem
                $operacao->caixa->decrement('saldo_atual', $operacao->valor);

                // Adiciona no caixa destino (se existir - evita erro em operação única)
                if ($operacao->caixa_destino_id) {
                    $operacao->caixaDestino->increment('saldo_atual', $operacao->valor);
                }

                \Log::info('🔄 Transferência realizada', [
                    'operacao_id' => $operacao->id,
                    'caixa_origem' => $operacao->caixa->nome,
                    'caixa_destino' => $operacao->caixaDestino?->nome,
                    'valor' => $operacao->valor,
                ]);
                break;
        }
    }

    /**
     * Reverte o saldo quando operação é estornada
     */
    protected function reverterSaldoCaixa(CaixaOperacao $operacao): void
    {
        switch ($operacao->tipo) {
            case CaixaOperacaoTipoEnum::SANGRIA:
                // Devolve ao saldo
                $operacao->caixa->increment('saldo_atual', $operacao->valor);

                Log::warning('🔙 Sangria estornada', [
                    'operacao_id' => $operacao->id,
                    'caixa' => $operacao->caixa->nome,
                    'valor' => $operacao->valor,
                ]);
                break;

            case CaixaOperacaoTipoEnum::REFORCO:
                // Remove do saldo
                $operacao->caixa->decrement('saldo_atual', $operacao->valor);

                Log::warning('🔙 Reforço estornado', [
                    'operacao_id' => $operacao->id,
                    'caixa' => $operacao->caixa->nome,
                    'valor' => $operacao->valor,
                ]);
                break;

            case CaixaOperacaoTipoEnum::TRANSFERENCIA:
                // Devolve ao caixa origem
                $operacao->caixa->increment('saldo_atual', $operacao->valor);

                // Remove do caixa destino
                if ($operacao->caixa_destino_id) {
                    $operacao->caixaDestino->decrement('saldo_atual', $operacao->valor);
                }

                Log::warning('🔙 Transferência estornada', [
                    'operacao_id' => $operacao->id,
                    'caixa_origem' => $operacao->caixa->nome,
                    'caixa_destino' => $operacao->caixaDestino?->nome,
                    'valor' => $operacao->valor,
                ]);
                break;
        }
    }

    /**
     * Recalcula o saldo quando o valor da operação é alterado
     */
    protected function recalcularSaldo(CaixaOperacao $operacao): void
    {
        $valorAntigo = $operacao->getOriginal('valor');
        $valorNovo = $operacao->valor;
        $diferenca = $valorNovo - $valorAntigo;

        switch ($operacao->tipo) {
            case CaixaOperacaoTipoEnum::SANGRIA:
                // Ajusta o saldo pela diferença (negativa)
                $operacao->caixa->decrement('saldo_atual', $diferenca);
                break;

            case CaixaOperacaoTipoEnum::REFORCO:
                // Ajusta o saldo pela diferença (positiva)
                $operacao->caixa->increment('saldo_atual', $diferenca);
                break;

            case CaixaOperacaoTipoEnum::TRANSFERENCIA:
                // Ajusta ambos os caixas
                $operacao->caixa->decrement('saldo_atual', $diferenca);
                if ($operacao->caixa_destino_id) {
                    $operacao->caixaDestino->increment('saldo_atual', $diferenca);
                }
                break;
        }

        Log::info('✏️ Operação atualizada - Saldo recalculado', [
            'operacao_id' => $operacao->id,
            'tipo' => $operacao->tipo->value,
            'valor_antigo' => $valorAntigo,
            'valor_novo' => $valorNovo,
            'diferenca' => $diferenca,
        ]);
    }
}
