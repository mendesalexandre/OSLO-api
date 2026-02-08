<?php

namespace App\Http\Controllers;

use App\Models\Ato;
use App\Traits\RespostaApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtoController extends Controller
{
    use RespostaApi;

    public function listar(Request $request): JsonResponse
    {
        $query = Ato::with('natureza:id,nome');

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'ilike', "%{$busca}%")
                    ->orWhere('codigo', 'ilike', "%{$busca}%");
            });
        }

        if ($request->filled('ativo')) {
            $query->where('ativo', $request->boolean('ativo'));
        }

        if ($request->filled('natureza_id')) {
            $query->where('natureza_id', $request->natureza_id);
        }

        if ($request->filled('tipo_calculo')) {
            $query->where('tipo_calculo', $request->tipo_calculo);
        }

        $porPagina = $request->integer('por_pagina', 15);

        return $this->sucessoPaginado(
            $query->orderBy('nome')->paginate($porPagina)
        );
    }

    public function criar(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'natureza_id' => 'required|exists:natureza,id',
            'codigo' => 'required|string|max:20|unique:ato,codigo',
            'nome' => 'required|string|max:200',
            'descricao' => 'nullable|string',
            'valor_fixo' => 'nullable|numeric|min:0',
            'percentual' => 'nullable|numeric|min:0',
            'valor_minimo' => 'nullable|numeric|min:0',
            'valor_maximo' => 'nullable|numeric|min:0',
            'tipo_calculo' => 'required|in:fixo,percentual,faixa,manual',
            'ativo' => 'boolean',
        ]);

        $ato = Ato::create($dados);

        return $this->criado($ato->load('natureza:id,nome'));
    }

    public function exibir(int $id): JsonResponse
    {
        $ato = Ato::with(['natureza:id,nome', 'faixas'])->find($id);

        if (!$ato) {
            return $this->naoEncontrado('Ato não encontrado');
        }

        return $this->sucesso($ato);
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {
        $ato = Ato::find($id);

        if (!$ato) {
            return $this->naoEncontrado('Ato não encontrado');
        }

        $dados = $request->validate([
            'natureza_id' => 'sometimes|exists:natureza,id',
            'codigo' => "sometimes|string|max:20|unique:ato,codigo,{$id}",
            'nome' => 'sometimes|string|max:200',
            'descricao' => 'nullable|string',
            'valor_fixo' => 'nullable|numeric|min:0',
            'percentual' => 'nullable|numeric|min:0',
            'valor_minimo' => 'nullable|numeric|min:0',
            'valor_maximo' => 'nullable|numeric|min:0',
            'tipo_calculo' => 'sometimes|in:fixo,percentual,faixa,manual',
            'ativo' => 'boolean',
        ]);

        $ato->update($dados);

        return $this->sucesso($ato->fresh()->load('natureza:id,nome'), 'Ato atualizado com sucesso');
    }

    public function excluir(int $id): JsonResponse
    {
        $ato = Ato::find($id);

        if (!$ato) {
            return $this->naoEncontrado('Ato não encontrado');
        }

        $ato->delete();

        return $this->sucesso(null, 'Ato excluído com sucesso');
    }

    public function restaurar(int $id): JsonResponse
    {
        $ato = Ato::withTrashed()->find($id);

        if (!$ato) {
            return $this->naoEncontrado('Ato não encontrado');
        }

        $ato->restore();

        return $this->sucesso($ato->fresh()->load('natureza:id,nome'), 'Ato restaurado com sucesso');
    }

    public function calcularValor(Request $request, int $id): JsonResponse
    {
        $ato = Ato::with('faixas')->find($id);

        if (!$ato) {
            return $this->naoEncontrado('Ato não encontrado');
        }

        $dados = $request->validate([
            'base_calculo' => 'nullable|numeric|min:0',
            'quantidade' => 'integer|min:1',
        ]);

        $valorUnitario = $ato->calcularValor($dados['base_calculo'] ?? null);
        $quantidade = $dados['quantidade'] ?? 1;

        return $this->sucesso([
            'valor_unitario' => $valorUnitario,
            'quantidade' => $quantidade,
            'valor_total' => round($valorUnitario * $quantidade, 2),
            'tipo_calculo' => $ato->tipo_calculo,
        ]);
    }
}
