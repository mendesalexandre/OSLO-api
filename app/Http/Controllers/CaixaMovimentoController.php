<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\CaixaMovimento;
use App\Enums\CaixaMovimentoStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CaixaMovimentoController extends Controller
{s
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', CaixaMovimento::class);

        $movimentos = CaixaMovimento::with([
            'caixa',
            'usuarioAbertura',
            'usuarioFechamento'
        ])->get();

        return response()->json($movimentos);
    }

    public function show($id): JsonResponse
    {
        $movimento = CaixaMovimento::with([
            'caixa',
            'usuarioAbertura',
            'usuarioFechamento',
            'transacoes'
        ])->findOrFail($id);

        $this->authorize('view', $movimento);

        return response()->json([
            'movimento' => $movimento,
            'resumo' => $movimento->getResumo()
        ]);
    }

    public function abrir(Request $request): JsonResponse
    {
        $this->authorize('abrir', CaixaMovimento::class);

        $validated = $request->validate([
            'caixa_id' => 'required|exists:caixa,id',
            'saldo_inicial_informado' => 'required|numeric|min:0',
            'observacao_abertura' => 'nullable|string|max:500',
        ]);

        $caixa = Caixa::findOrFail($validated['caixa_id']);

        // Verificar se já existe movimento aberto para este caixa
        if ($caixa->temMovimentoAberto()) {
            return response()->json([
                'error' => 'Já existe um movimento aberto para este caixa',
                'movimento_aberto' => $caixa->movimentoAtual()
            ], 422);
        }

        $movimento = CaixaMovimento::create([
            'caixa_id' => $caixa->id,
            'usuario_abertura_id' => auth()->id(),
            'data_abertura' => now(),
            'saldo_inicial_informado' => $validated['saldo_inicial_informado'],
            'saldo_inicial_sistema' => $caixa->saldo_atual,
            'observacao_abertura' => $validated['observacao_abertura'] ?? null,
            'status' => CaixaMovimentoStatus::ABERTO,
        ]);

        $movimento->load(['caixa', 'usuarioAbertura']);

        return response()->json([
            'message' => 'Caixa aberto com sucesso',
            'movimento' => $movimento
        ], 201);
    }

    public function fechar(Request $request, $id): JsonResponse
    {
        $movimento = CaixaMovimento::findOrFail($id);

        $this->authorize('fechar', $movimento);

        if (!$movimento->isAberto()) {
            return response()->json([
                'error' => 'Este movimento já está fechado'
            ], 422);
        }

        $validated = $request->validate([
            'saldo_final_informado' => 'required|numeric|min:0',
            'observacao_fechamento' => 'nullable|string|max:500',
        ]);

        $movimento->fechar(
            $validated['saldo_final_informado'],
            $validated['observacao_fechamento'] ?? null
        );

        $movimento->load(['caixa', 'usuarioAbertura', 'usuarioFechamento']);

        $resumo = $movimento->getResumo();

        return response()->json([
            'message' => 'Caixa fechado com sucesso',
            'movimento' => $movimento,
            'resumo' => $resumo,
            'alerta' => $movimento->temDiferenca() ? 'Atenção: Há diferença entre o saldo contado e o calculado!' : null
        ]);
    }

    public function conferir($id): JsonResponse
    {
        $movimento = CaixaMovimento::findOrFail($id);

        $this->authorize('conferir', $movimento);

        try {
            $movimento->conferir();

            return response()->json([
                'message' => 'Movimento conferido com sucesso',
                'movimento' => $movimento
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function reabrir(Request $request, $id): JsonResponse
    {
        $movimento = CaixaMovimento::findOrFail($id);

        $this->authorize('reabrir', $movimento);

        $validated = $request->validate([
            'motivo' => 'required|string|max:500',
        ]);

        try {
            $movimento->reabrir($validated['motivo']);

            return response()->json([
                'message' => 'Movimento reaberto com sucesso',
                'movimento' => $movimento
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function abertos(): JsonResponse
    {
        $this->authorize('viewAny', CaixaMovimento::class);

        $movimentos = CaixaMovimento::with([
            'caixa',
            'usuarioAbertura'
        ])
            ->abertos()
            ->get();

        return response()->json($movimentos);
    }

    public function fechados(): JsonResponse
    {
        $this->authorize('viewAny', CaixaMovimento::class);

        $movimentos = CaixaMovimento::with([
            'caixa',
            'usuarioAbertura',
            'usuarioFechamento'
        ])
            ->fechados()
            ->orderBy('data_fechamento', 'desc')
            ->get();

        return response()->json($movimentos);
    }

    public function comDiferenca(): JsonResponse
    {
        $this->authorize('viewAny', CaixaMovimento::class);

        $movimentos = CaixaMovimento::with([
            'caixa',
            'usuarioAbertura',
            'usuarioFechamento'
        ])
            ->comDiferenca()
            ->orderBy('data_fechamento', 'desc')
            ->get();

        return response()->json($movimentos);
    }

    public function movimentoAtual($caixaId): JsonResponse
    {
        $this->authorize('viewAny', CaixaMovimento::class);

        $caixa = Caixa::findOrFail($caixaId);
        $movimento = $caixa->movimentoAtual();

        if (!$movimento) {
            return response()->json([
                'message' => 'Não há movimento aberto para este caixa'
            ], 404);
        }

        $movimento->load(['usuarioAbertura', 'transacoes']);

        return response()->json([
            'movimento' => $movimento,
            'resumo_parcial' => [
                'tempo_aberto' => $movimento->getTempoAberto(),
                'total_transacoes' => $movimento->transacoes->count(),
            ]
        ]);
    }
}
