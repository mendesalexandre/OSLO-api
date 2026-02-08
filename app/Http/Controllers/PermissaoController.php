<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use App\Traits\RespostaApi;
use App\Traits\VerificaPermissao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissaoController extends Controller
{
    use RespostaApi, VerificaPermissao;

    public function listar(Request $request): JsonResponse
    {
        $query = Permissao::query();

        if ($request->has('ativo')) {
            $query->where('ativo', $request->boolean('ativo'));
        }

        if ($request->has('modulo')) {
            $query->porModulo($request->input('modulo'));
        }

        if ($request->has('busca')) {
            $busca = $request->input('busca');
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'ilike', "%{$busca}%")
                    ->orWhere('descricao', 'ilike', "%{$busca}%");
            });
        }

        $permissoes = $request->has('por_pagina')
            ? $query->orderBy('modulo')->orderBy('nome')->paginate($request->input('por_pagina', 15))
            : $query->orderBy('modulo')->orderBy('nome')->get();

        if ($permissoes instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return $this->sucessoPaginado($permissoes);
        }

        return $this->sucesso($permissoes);
    }

    public function criar(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:permissao,nome',
            'descricao' => 'required|string|max:300',
            'modulo' => 'required|string|max:50',
            'ativo' => 'boolean',
        ], [
            'nome.required' => 'O nome da permissão é obrigatório.',
            'nome.unique' => 'Já existe uma permissão com este nome.',
            'descricao.required' => 'A descrição é obrigatória.',
            'modulo.required' => 'O módulo é obrigatório.',
        ]);

        $permissao = Permissao::create($request->only(['nome', 'descricao', 'modulo', 'ativo']));

        return $this->criado($permissao);
    }

    public function exibir(int $id): JsonResponse
    {
        $permissao = Permissao::with(['grupos:id,nome', 'usuarios:id,nome,email'])
            ->find($id);

        if (!$permissao) {
            return $this->naoEncontrado('Permissão não encontrada.');
        }

        return $this->sucesso($permissao);
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {
        $permissao = Permissao::find($id);

        if (!$permissao) {
            return $this->naoEncontrado('Permissão não encontrada.');
        }

        $request->validate([
            'nome' => "sometimes|required|string|max:100|unique:permissao,nome,{$id}",
            'descricao' => 'sometimes|required|string|max:300',
            'modulo' => 'sometimes|required|string|max:50',
            'ativo' => 'boolean',
        ]);

        $permissao->update($request->only(['nome', 'descricao', 'modulo', 'ativo']));

        return $this->sucesso($permissao, 'Permissão atualizada com sucesso.');
    }

    public function excluir(int $id): JsonResponse
    {
        $permissao = Permissao::find($id);

        if (!$permissao) {
            return $this->naoEncontrado('Permissão não encontrada.');
        }

        $permissao->delete();

        return $this->sucesso(null, 'Permissão excluída com sucesso.');
    }

    public function restaurar(int $id): JsonResponse
    {
        $permissao = Permissao::withTrashed()->find($id);

        if (!$permissao) {
            return $this->naoEncontrado('Permissão não encontrada.');
        }

        $permissao->restore();

        return $this->sucesso($permissao, 'Permissão restaurada com sucesso.');
    }

    public function listarModulos(): JsonResponse
    {
        return $this->sucesso(Permissao::modulos());
    }

    public function listarPorModulo(string $modulo): JsonResponse
    {
        $permissoes = Permissao::ativos()
            ->porModulo($modulo)
            ->orderBy('nome')
            ->get();

        return $this->sucesso($permissoes);
    }
}
