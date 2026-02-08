<?php

namespace App\Http\Controllers;

use App\Enums\TransacaoNaturezaEnum;
use App\Models\Transacao;
use App\Http\Requests\TransacaoRequest;
use App\Enums\TransacaoStatus;
use App\Enums\TransacaoStatusEnum;
use App\Enums\TransacaoTipoEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransacaoController extends Controller
{
    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', Transacao::class);

        $transacoes = Transacao::with([
            'caixa',
            'categoria',
            'tipoPagamento',
            'meioPagamento',
            'pessoa',
            'usuario',
            'pagamentos.pessoa',
            'pagamentos.tipoPagamento',
            'pagamentos.meioPagamento'
        ])->get();

        return response()->json($transacoes);
    }

    public function store(TransacaoRequest $request): JsonResponse
    {
        // $this->authorize('create', Transacao::class);

        $transacao = Transacao::create($request->validated());

        $transacao->load([
            'caixa',
            'categoria',
            'tipoPagamento',
            'meioPagamento',
            'pessoa'
        ]);

        return response()->json($transacao, 201);
    }

    public function show($id): JsonResponse
    {
        $transacao = Transacao::with([
            'caixa',
            'categoria',
            'tipoPagamento',
            'meioPagamento',
            'pessoa',
            'usuario',
            'pagamentos.pessoa',
            'pagamentos.tipoPagamento',
            'pagamentos.meioPagamento'
        ])->findOrFail($id);

        // $this->authorize('view', $transacao);

        return response()->json($transacao);
    }

    public function update(TransacaoRequest $request, $id): JsonResponse
    {
        $transacao = Transacao::findOrFail($id);

        $transacao->update($request->validated());

        $transacao->load([
            'caixa',
            'categoria',
            'tipoPagamento',
            'meioPagamento',
            'pessoa'
        ]);

        return response()->json($transacao);
    }

    public function destroy($id): JsonResponse
    {
        $transacao = Transacao::findOrFail($id);

        $transacao->delete();

        return response()->json(['message' => 'Transação excluída com sucesso']);
    }

    public function pagar(Request $request, $id): JsonResponse
    {
        $transacao = Transacao::findOrFail($id);

        // $this->authorize('pagar', $transacao);

        // Verificar se a transação já está paga
        if ($transacao->isTotalmentePago()) {
            return response()->json([
                'error' => 'Esta transação já está totalmente paga',
                'valor_total' => $transacao->valor,
                'valor_pago' => $transacao->totalPago(),
                'valor_restante' => 0
            ], 422);
        }

        // Verificar se está cancelada
        if ($transacao->isCancelado()) {
            return response()->json([
                'error' => 'Não é possível pagar uma transação cancelada'
            ], 422);
        }

        $validated = $request->validate([
            'valor_pago' => 'required|numeric|min:0.01',
            'tipo_pagamento_id' => 'required|exists:tipo_pagamento,id',
            'meio_pagamento_id' => 'nullable|exists:meio_pagamento,id',
            'pessoa_id' => 'nullable|exists:pessoa,id',
            'observacao' => 'nullable|string|max:500',
        ]);

        // Verificar se o valor pago não excede o valor restante
        $valorRestante = $transacao->valorRestantePagar();

        if ($validated['valor_pago'] > $valorRestante) {
            return response()->json([
                'error' => 'O valor do pagamento não pode ser maior que o valor restante',
                'valor_pago_tentado' => $validated['valor_pago'],
                'valor_restante' => $valorRestante,
                'sugestao' => 'Use o valor restante para finalizar o pagamento'
            ], 422);
        }

        // Criar pagamento
        $pagamento = $transacao->pagamentos()->create([
            'valor_pago' => $validated['valor_pago'],
            'tipo_pagamento_id' => $validated['tipo_pagamento_id'],
            'meio_pagamento_id' => $validated['meio_pagamento_id'] ?? null,
            'pessoa_id' => $validated['pessoa_id'] ?? null,
            'observacao' => $validated['observacao'] ?? null,
            'is_pago' => false,
        ]);

        // Calcular taxa se tiver meio de pagamento
        if ($pagamento->meio_pagamento_id) {
            $pagamento->calcularTaxa();
        }

        // Marcar como pago
        $pagamento->marcarComoPago();

        $transacao->load('pagamentos');

        $valorRestanteAtualizado = $transacao->valorRestantePagar();

        return response()->json([
            'message' => $valorRestanteAtualizado > 0
                ? 'Pagamento parcial registrado com sucesso'
                : 'Transação paga totalmente com sucesso',
            'transacao' => $transacao,
            'pagamento' => $pagamento,
            'valor_restante' => $valorRestanteAtualizado,
            'status_pagamento' => $valorRestanteAtualizado > 0 ? 'PARCIAL' : 'TOTAL'
        ]);
    }

    public function cancelar($id): JsonResponse
    {
        $transacao = Transacao::findOrFail($id);

        $transacao->update([
            'status' => TransacaoStatusEnum::CANCELADO
        ]);

        return response()->json([
            'message' => 'Transação cancelada com sucesso',
            'transacao' => $transacao
        ]);
    }

    public function pendentes(): JsonResponse
    {
        $transacoes = Transacao::with([
            'caixa',
            'categoria',
            'pessoa'
        ])
            ->pendentes()
            ->get();

        return response()->json($transacoes);
    }

    public function vencidas(): JsonResponse
    {
        $transacoes = Transacao::with([
            'caixa',
            'categoria',
            'pessoa'
        ])
            ->vencidas()
            ->get();

        return response()->json($transacoes);
    }

    public function contasPagar(): JsonResponse
    {
        $transacoes = Transacao::with([
            'caixa',
            'categoria',
            'pessoa'
        ])
            ->contasPagar()
            ->pendentes()
            ->get();

        return response()->json($transacoes);
    }

    public function contasReceber(): JsonResponse
    {
        $transacoes = Transacao::with([
            'caixa',
            'categoria',
            'pessoa'
        ])
            ->contasReceber()
            ->pendentes()
            ->get();

        return response()->json($transacoes);
    }

    // TransacaoController
    public function transferir(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'caixa_origem_id' => 'required|exists:caixa,id',
            'caixa_destino_id' => 'required|exists:caixa,id|different:caixa_origem_id',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Criar transação de SAÍDA no caixa origem
            $transacaoSaida = Transacao::create([
                'caixa_id' => $validated['caixa_origem_id'],
                'tipo' => TransacaoTipoEnum::SAIDA,
                'natureza' => TransacaoNaturezaEnum::TRANSFERENCIA,
                'descricao' => $validated['descricao'],
                'valor' => $validated['valor'],
                'status' => TransacaoStatusEnum::PAGO,
                'data_vencimento' => now(),
                'data_pagamento' => now(),
                'valor_pago' => $validated['valor'],
                'usuario_id' => auth()->id(),
            ]);

            // Criar transação de ENTRADA no caixa destino
            $transacaoEntrada = Transacao::create([
                'caixa_id' => $validated['caixa_destino_id'],
                'tipo' => TransacaoTipoEnum::ENTRADA,
                'natureza' => TransacaoNaturezaEnum::TRANSFERENCIA,
                'descricao' => $validated['descricao'],
                'valor' => $validated['valor'],
                'status' => TransacaoStatusEnum::PAGO,
                'data_vencimento' => now(),
                'data_pagamento' => now(),
                'valor_pago' => $validated['valor'],
                'usuario_id' => auth()->id(),
                'transacao_vinculada_id' => $transacaoSaida->id,
            ]);

            // Vincular as duas
            $transacaoSaida->update(['transacao_vinculada_id' => $transacaoEntrada->id]);

            DB::commit();

            return response()->json([
                'message' => 'Transferência realizada com sucesso',
                'transacao_saida' => $transacaoSaida,
                'transacao_entrada' => $transacaoEntrada
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao realizar transferência',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
