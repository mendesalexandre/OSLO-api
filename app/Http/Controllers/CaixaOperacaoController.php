<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\CaixaOperacao;
use App\Enums\CaixaOperacaoTipoEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaixaOperacaoController extends Controller
{
    public function index(): JsonResponse
    {

        $operacoes = CaixaOperacao::with([
            'caixa',
            'caixaDestino',
            'usuario'
        ])
            ->recentes()
            ->get();

        return response()->json($operacoes);
    }

    public function show($id): JsonResponse
    {
        $operacao = CaixaOperacao::with([
            'caixa',
            'caixaDestino',
            'operacaoVinculada',
            'usuario'
        ])->findOrFail($id);

        return response()->json([
            'operacao' => $operacao,
            'resumo' => $operacao->getResumo()
        ]);
    }

    public function sangria(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'caixa_id' => 'required|exists:caixa,id',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
            'observacao' => 'nullable|string|max:500',
        ]);

        $caixa = Caixa::findOrFail($validated['caixa_id']);

        // Validar se tem saldo suficiente
        if ($caixa->saldo_atual < $validated['valor']) {
            return response()->json([
                'error' => 'Saldo insuficiente para realizar a sangria',
                'saldo_disponivel' => $caixa->saldo_atual,
                'valor_solicitado' => $validated['valor']
            ], 422);
        }

        $operacao = CaixaOperacao::create([
            'caixa_id' => $validated['caixa_id'],
            'tipo' => CaixaOperacaoTipoEnum::SANGRIA,
            'valor' => $validated['valor'],
            'descricao' => $validated['descricao'],
            'observacao' => $validated['observacao'] ?? null,
            'usuario_id' => auth()->id(),
            'data_operacao' => now(),
        ]);

        $operacao->load(['caixa', 'usuario']);

        return response()->json([
            'message' => 'Sangria realizada com sucesso',
            'operacao' => $operacao,
            'saldo_anterior' => $caixa->saldo_atual,
            'saldo_atual' => $caixa->fresh()->saldo_atual
        ], 201);
    }

    public function reforco(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'caixa_id' => 'required|exists:caixa,id',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
            'observacao' => 'nullable|string|max:500',
        ]);

        $caixa = Caixa::findOrFail($validated['caixa_id']);

        $operacao = CaixaOperacao::create([
            'caixa_id' => $validated['caixa_id'],
            'tipo' => CaixaOperacaoTipoEnum::REFORCO,
            'valor' => $validated['valor'],
            'descricao' => $validated['descricao'],
            'observacao' => $validated['observacao'] ?? null,
            'usuario_id' => auth()->id(),
            'data_operacao' => now(),
        ]);

        $operacao->load(['caixa', 'usuario']);

        return response()->json([
            'message' => 'Reforço realizado com sucesso',
            'operacao' => $operacao,
            'saldo_anterior' => $caixa->saldo_atual,
            'saldo_atual' => $caixa->fresh()->saldo_atual
        ], 201);
    }

    public function transferir(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'caixa_origem_id' => 'required|exists:caixa,id',
            'caixa_destino_id' => 'required|exists:caixa,id|different:caixa_origem_id',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
            'observacao' => 'nullable|string|max:500',
        ], [
            'caixa_destino_id.different' => 'O caixa de destino deve ser diferente do caixa de origem'
        ]);

        $caixaOrigem = Caixa::findOrFail($validated['caixa_origem_id']);
        $caixaDestino = Caixa::findOrFail($validated['caixa_destino_id']);

        // Validar se tem saldo suficiente
        if ($caixaOrigem->saldo_atual < $validated['valor']) {
            return response()->json([
                'error' => 'Saldo insuficiente no caixa de origem',
                'saldo_disponivel' => $caixaOrigem->saldo_atual,
                'valor_solicitado' => $validated['valor']
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Criar operação de SAÍDA no caixa origem
            $operacaoSaida = CaixaOperacao::create([
                'caixa_id' => $validated['caixa_origem_id'],
                'caixa_destino_id' => $validated['caixa_destino_id'],
                'tipo' => CaixaOperacaoTipoEnum::TRANSFERENCIA,
                'valor' => $validated['valor'],
                'descricao' => $validated['descricao'],
                'observacao' => $validated['observacao'] ?? null,
                'usuario_id' => auth()->id(),
                'data_operacao' => now(),
            ]);

            // Criar operação de ENTRADA no caixa destino
            $operacaoEntrada = CaixaOperacao::create([
                'caixa_id' => $validated['caixa_destino_id'],
                'caixa_destino_id' => $validated['caixa_origem_id'],
                'tipo' => CaixaOperacaoTipoEnum::TRANSFERENCIA,
                'valor' => $validated['valor'],
                'descricao' => $validated['descricao'],
                'observacao' => $validated['observacao'] ?? null,
                'usuario_id' => auth()->id(),
                'data_operacao' => now(),
                'caixa_operacao_vinculada_id' => $operacaoSaida->id,
            ]);

            // Vincular as duas operações
            $operacaoSaida->update(['caixa_operacao_vinculada_id' => $operacaoEntrada->id]);

            DB::commit();

            $operacaoSaida->load(['caixa', 'caixaDestino', 'usuario']);
            $operacaoEntrada->load(['caixa', 'caixaDestino', 'usuario']);

            return response()->json([
                'message' => 'Transferência realizada com sucesso',
                'operacao_saida' => $operacaoSaida,
                'operacao_entrada' => $operacaoEntrada,
                'caixa_origem' => [
                    'nome' => $caixaOrigem->nome,
                    'saldo_anterior' => $caixaOrigem->saldo_atual,
                    'saldo_atual' => $caixaOrigem->fresh()->saldo_atual
                ],
                'caixa_destino' => [
                    'nome' => $caixaDestino->nome,
                    'saldo_anterior' => $caixaDestino->saldo_atual,
                    'saldo_atual' => $caixaDestino->fresh()->saldo_atual
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao realizar transferência',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function estornar($id): JsonResponse
    {
        $operacao = CaixaOperacao::findOrFail($id);

        if (!$operacao->podeSerEstornada()) {
            return response()->json([
                'error' => 'Esta operação não pode ser estornada. Para transferências, estorne ambas as operações.'
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Se for transferência, estornar também a operação vinculada
            if ($operacao->isTransferencia() && $operacao->temOperacaoVinculada()) {
                $operacaoVinculada = $operacao->operacaoVinculada;
                $operacaoVinculada->delete();
            }

            $operacao->delete();

            DB::commit();

            return response()->json([
                'message' => 'Operação estornada com sucesso'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao estornar operação',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Consultas específicas
    public function sangrias(): JsonResponse
    {

        $operacoes = CaixaOperacao::with(['caixa', 'usuario'])
            ->sangrias()
            ->recentes()
            ->get();

        return response()->json($operacoes);
    }

    public function reforcos(): JsonResponse
    {

        $operacoes = CaixaOperacao::with(['caixa', 'usuario'])
            ->reforcos()
            ->recentes()
            ->get();

        return response()->json($operacoes);
    }

    public function transferencias(): JsonResponse
    {

        $operacoes = CaixaOperacao::with(['caixa', 'caixaDestino', 'usuario'])
            ->transferencias()
            ->recentes()
            ->get();

        return response()->json($operacoes);
    }

    public function porCaixa($caixaId): JsonResponse
    {

        $caixa = Caixa::findOrFail($caixaId);

        $operacoes = CaixaOperacao::with(['caixa', 'caixaDestino', 'usuario'])
            ->doCaixa($caixaId)
            ->recentes()
            ->get();

        return response()->json([
            'caixa' => $caixa,
            'operacoes' => $operacoes
        ]);
    }
}
