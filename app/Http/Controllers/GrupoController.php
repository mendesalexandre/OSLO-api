<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Permissao;
use App\Traits\RespostaApi;
use App\Traits\VerificaPermissao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    use RespostaApi, VerificaPermissao;

    public function listar(Request $request): JsonResponse
    {
        $query = Grupo::query()->with('permissoes:id,nome,modulo');

        if ($request->has('ativo')) {
            $query->where('ativo', $request->boolean('ativo'));
        }

        if ($request->has('busca')) {
            $busca = $request->input('busca');
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'ilike', "%{$busca}%")
                    ->orWhere('descricao', 'ilike', "%{$busca}%");
            });
        }

        $grupos = $request->has('por_pagina')
            ? $query->orderBy('nome')->paginate($request->input('por_pagina', 15))
            : $query->orderBy('nome')->get();

        if ($grupos instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return $this->sucessoPaginado($grupos);
        }

        return $this->sucesso($grupos);
    }

    public function criar(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:grupo,nome',
            'descricao' => 'required|string|max:300',
            'ativo' => 'boolean',
        ], [
            'nome.required' => 'O nome do grupo é obrigatório.',
            'nome.unique' => 'Já existe um grupo com este nome.',
            'descricao.required' => 'A descrição é obrigatória.',
        ]);

        $grupo = Grupo::create($request->only(['nome', 'descricao', 'ativo']));
        $grupo->load('permissoes:id,nome,modulo');

        return $this->criado($grupo);
    }

    public function exibir(int $id): JsonResponse
    {
        $grupo = Grupo::with(['permissoes:id,nome,descricao,modulo', 'usuarios:id,nome,email'])
            ->find($id);

        if (!$grupo) {
            return $this->naoEncontrado('Grupo não encontrado.');
        }

        return $this->sucesso($grupo);
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return $this->naoEncontrado('Grupo não encontrado.');
        }

        $request->validate([
            'nome' => "sometimes|required|string|max:100|unique:grupo,nome,{$id}",
            'descricao' => 'sometimes|required|string|max:300',
            'ativo' => 'boolean',
        ]);

        $grupo->update($request->only(['nome', 'descricao', 'ativo']));
        $grupo->load('permissoes:id,nome,modulo');

        return $this->sucesso($grupo, 'Grupo atualizado com sucesso.');
    }

    public function excluir(int $id): JsonResponse
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return $this->naoEncontrado('Grupo não encontrado.');
        }

        if ($grupo->nome === 'Administrador') {
            return $this->erro('O grupo Administrador não pode ser excluído.', 422);
        }

        $grupo->delete();

        return $this->sucesso(null, 'Grupo excluído com sucesso.');
    }

    public function restaurar(int $id): JsonResponse
    {
        $grupo = Grupo::withTrashed()->find($id);

        if (!$grupo) {
            return $this->naoEncontrado('Grupo não encontrado.');
        }

        $grupo->restore();
        $grupo->load('permissoes:id,nome,modulo');

        return $this->sucesso($grupo, 'Grupo restaurado com sucesso.');
    }

    public function sincronizarPermissoes(Request $request, int $id): JsonResponse
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return $this->naoEncontrado('Grupo não encontrado.');
        }

        $request->validate([
            'permissao_ids' => 'required|array',
            'permissao_ids.*' => 'integer|exists:permissao,id',
        ]);

        $grupo->permissoes()->sync($request->input('permissao_ids'));
        $grupo->load('permissoes:id,nome,modulo');

        return $this->sucesso($grupo, 'Permissões do grupo sincronizadas com sucesso.');
    }

    public function adicionarPermissao(Request $request, int $id): JsonResponse
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return $this->naoEncontrado('Grupo não encontrado.');
        }

        $request->validate([
            'permissao_id' => 'required|integer|exists:permissao,id',
        ]);

        $grupo->permissoes()->syncWithoutDetaching([$request->input('permissao_id')]);
        $grupo->load('permissoes:id,nome,modulo');

        return $this->sucesso($grupo, 'Permissão adicionada ao grupo com sucesso.');
    }

    public function removerPermissao(int $id, int $permissaoId): JsonResponse
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return $this->naoEncontrado('Grupo não encontrado.');
        }

        $grupo->permissoes()->detach($permissaoId);
        $grupo->load('permissoes:id,nome,modulo');

        return $this->sucesso($grupo, 'Permissão removida do grupo com sucesso.');
    }
}
