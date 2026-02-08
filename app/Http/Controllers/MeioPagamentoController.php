<?php

namespace App\Http\Controllers;

use App\Models\MeioPagamento;
use App\Traits\RespostaApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeioPagamentoController extends Controller
{
    use RespostaApi;

    public function listar(Request $request): JsonResponse
    {
        $query = MeioPagamento::with('formaPagamento:id,nome');

        if ($request->filled('busca')) {
            $query->where('nome', 'ilike', "%{$request->busca}%");
        }

        if ($request->filled('is_ativo')) {
            $query->where('is_ativo', $request->boolean('is_ativo'));
        }

        if ($request->filled('forma_pagamento_id')) {
            $query->where('forma_pagamento_id', $request->forma_pagamento_id);
        }

        $porPagina = $request->integer('por_pagina', 15);

        return $this->sucessoPaginado(
            $query->orderBy('nome')->paginate($porPagina)
        );
    }

    public function criar(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'forma_pagamento_id' => 'nullable|exists:forma_pagamento,id',
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string|max:255',
            'identificador' => 'nullable|string|max:100',
            'taxa_percentual' => 'numeric|min:0',
            'taxa_fixa' => 'numeric|min:0',
            'prazo_compensacao' => 'integer|min:0',
            'is_ativo' => 'boolean',
        ]);

        $meioPagamento = MeioPagamento::create($dados);

        return $this->criado($meioPagamento->load('formaPagamento:id,nome'));
    }

    public function exibir(int $id): JsonResponse
    {
        $meioPagamento = MeioPagamento::with('formaPagamento:id,nome')->find($id);

        if (!$meioPagamento) {
            return $this->naoEncontrado('Meio de pagamento não encontrado');
        }

        return $this->sucesso($meioPagamento);
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {
        $meioPagamento = MeioPagamento::find($id);

        if (!$meioPagamento) {
            return $this->naoEncontrado('Meio de pagamento não encontrado');
        }

        $dados = $request->validate([
            'forma_pagamento_id' => 'nullable|exists:forma_pagamento,id',
            'nome' => 'sometimes|string|max:100',
            'descricao' => 'nullable|string|max:255',
            'identificador' => 'nullable|string|max:100',
            'taxa_percentual' => 'numeric|min:0',
            'taxa_fixa' => 'numeric|min:0',
            'prazo_compensacao' => 'integer|min:0',
            'is_ativo' => 'boolean',
        ]);

        $meioPagamento->update($dados);

        return $this->sucesso($meioPagamento->fresh()->load('formaPagamento:id,nome'), 'Meio de pagamento atualizado com sucesso');
    }

    public function excluir(int $id): JsonResponse
    {
        $meioPagamento = MeioPagamento::find($id);

        if (!$meioPagamento) {
            return $this->naoEncontrado('Meio de pagamento não encontrado');
        }

        $meioPagamento->delete();

        return $this->sucesso(null, 'Meio de pagamento excluído com sucesso');
    }

    public function restaurar(int $id): JsonResponse
    {
        $meioPagamento = MeioPagamento::withTrashed()->find($id);

        if (!$meioPagamento) {
            return $this->naoEncontrado('Meio de pagamento não encontrado');
        }

        $meioPagamento->restore();

        return $this->sucesso($meioPagamento->fresh()->load('formaPagamento:id,nome'), 'Meio de pagamento restaurado com sucesso');
    }
}
