<?php

namespace App\Http\Controllers;

use App\Models\FormaPagamento;
use App\Traits\RespostaApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormaPagamentoController extends Controller
{
    use RespostaApi;

    public function listar(Request $request): JsonResponse
    {
        $query = FormaPagamento::query();

        if ($request->filled('busca')) {
            $query->where('nome', 'ilike', "%{$request->busca}%");
        }

        if ($request->filled('ativo')) {
            $query->where('ativo', $request->boolean('ativo'));
        }

        $porPagina = $request->integer('por_pagina', 15);

        return $this->sucessoPaginado(
            $query->orderBy('nome')->paginate($porPagina)
        );
    }

    public function criar(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:100|unique:forma_pagamento,nome',
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        $formaPagamento = FormaPagamento::create($dados);

        return $this->criado($formaPagamento);
    }

    public function exibir(int $id): JsonResponse
    {
        $formaPagamento = FormaPagamento::with('meiosPagamento')->find($id);

        if (!$formaPagamento) {
            return $this->naoEncontrado('Forma de pagamento não encontrada');
        }

        return $this->sucesso($formaPagamento);
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {
        $formaPagamento = FormaPagamento::find($id);

        if (!$formaPagamento) {
            return $this->naoEncontrado('Forma de pagamento não encontrada');
        }

        $dados = $request->validate([
            'nome' => "sometimes|string|max:100|unique:forma_pagamento,nome,{$id}",
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        $formaPagamento->update($dados);

        return $this->sucesso($formaPagamento->fresh(), 'Forma de pagamento atualizada com sucesso');
    }

    public function excluir(int $id): JsonResponse
    {
        $formaPagamento = FormaPagamento::find($id);

        if (!$formaPagamento) {
            return $this->naoEncontrado('Forma de pagamento não encontrada');
        }

        $formaPagamento->delete();

        return $this->sucesso(null, 'Forma de pagamento excluída com sucesso');
    }

    public function restaurar(int $id): JsonResponse
    {
        $formaPagamento = FormaPagamento::withTrashed()->find($id);

        if (!$formaPagamento) {
            return $this->naoEncontrado('Forma de pagamento não encontrada');
        }

        $formaPagamento->restore();

        return $this->sucesso($formaPagamento->fresh(), 'Forma de pagamento restaurada com sucesso');
    }
}
