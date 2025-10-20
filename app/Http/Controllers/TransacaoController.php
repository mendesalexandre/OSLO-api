<?php

namespace App\Http\Controllers;

use App\Models\Transacao;
use App\Http\Requests\TransacaoRequest;
use App\Enums\TransacaoStatus;
use App\Enums\TransacaoStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransacaoController extends Controller
{
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Transacao::class);

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

        $this->authorize('view', $transacao);

        return response()->json($transacao);
    }

    public function update(TransacaoRequest $request, $id): JsonResponse
    {
        $transacao = Transacao::findOrFail($id);

        $this->authorize('update', $transacao);

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

        $this->authorize('delete', $transacao);

        $transacao->delete();

        return response()->json(['message' => 'Transação excluída com sucesso']);
    }

    public function pagar(Request $request, $id): JsonResponse
    {
        $transacao = Transacao::findOrFail($id);

        $this->authorize('pagar', $transacao);

        $validated = $request->validate([
            'valor_pago' => 'required|numeric|min:0',
            'tipo_pagamento_id' => 'required|exists:tipo_pagamento,id',
            'meio_pagamento_id' => 'nullable|exists:meio_pagamento,id',
            'pessoa_id' => 'nullable|exists:pessoa,id',
            'observacao' => 'nullable|string|max:500',
        ]);

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

        return response()->json([
            'message' => 'Pagamento registrado com sucesso',
            'transacao' => $transacao,
            'pagamento' => $pagamento,
            'valor_restante' => $transacao->valorRestantePagar()
        ]);
    }

    public function cancelar($id): JsonResponse
    {
        $transacao = Transacao::findOrFail($id);

        $this->authorize('cancelar', $transacao);

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
        $this->authorize('viewAny', Transacao::class);

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
        $this->authorize('viewAny', Transacao::class);

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
        $this->authorize('viewAny', Transacao::class);

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
        $this->authorize('viewAny', Transacao::class);

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
}
