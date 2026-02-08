<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grupo;
use App\Models\Permissao;
use App\Traits\RespostaApi;
use App\Traits\VerificaPermissao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioPermissaoController extends Controller
{
    use RespostaApi, VerificaPermissao;

    public function listarUsuarios(Request $request): JsonResponse
    {
        $query = User::query()->select('id', 'nome', 'email', 'is_ativo', 'data_cadastro');

        if ($busca = $request->input('busca')) {
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'ilike', "%{$busca}%")
                  ->orWhere('email', 'ilike', "%{$busca}%");
            });
        }

        if ($request->has('ativo')) {
            $query->where('is_ativo', $request->boolean('ativo'));
        }

        $query->with('grupos:id,nome');
        $query->orderBy('nome');

        $porPagina = $request->input('por_pagina', 15);

        if ($request->input('sem_paginacao')) {
            return $this->sucesso($query->get());
        }

        return $this->sucesso($query->paginate($porPagina));
    }

    public function listar(int $usuarioId): JsonResponse
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            return $this->naoEncontrado('Usuário não encontrado.');
        }

        return $this->sucesso([
            'grupos' => $usuario->grupos()->with('permissoes:id,nome,modulo')->get(),
            'permissoes_individuais' => $usuario->permissoesIndividuais()->get()->map(function ($p) {
                return [
                    'id' => $p->id,
                    'nome' => $p->nome,
                    'descricao' => $p->descricao,
                    'modulo' => $p->modulo,
                    'tipo' => $p->pivot->tipo,
                ];
            }),
        ]);
    }

    public function permissoesEfetivas(int $usuarioId): JsonResponse
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            return $this->naoEncontrado('Usuário não encontrado.');
        }

        return $this->sucesso([
            'permissoes' => $usuario->obterPermissoes(),
            'modulos' => $usuario->obterPermissoesPorModulo(),
            'grupos' => $usuario->grupos()->ativos()->pluck('nome')->toArray(),
            'is_admin' => $usuario->isAdmin(),
        ]);
    }

    public function sincronizarGrupos(Request $request, int $usuarioId): JsonResponse
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            return $this->naoEncontrado('Usuário não encontrado.');
        }

        $request->validate([
            'grupo_ids' => 'required|array',
            'grupo_ids.*' => 'integer|exists:grupo,id',
        ]);

        $usuario->grupos()->sync($request->input('grupo_ids'));

        return $this->sucesso([
            'grupos' => $usuario->grupos()->get(),
        ], 'Grupos do usuário sincronizados com sucesso.');
    }

    public function adicionarGrupo(Request $request, int $usuarioId): JsonResponse
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            return $this->naoEncontrado('Usuário não encontrado.');
        }

        $request->validate([
            'grupo_id' => 'required|integer|exists:grupo,id',
        ]);

        $usuario->grupos()->syncWithoutDetaching([$request->input('grupo_id')]);

        return $this->sucesso([
            'grupos' => $usuario->grupos()->get(),
        ], 'Grupo adicionado ao usuário com sucesso.');
    }

    public function removerGrupo(int $usuarioId, int $grupoId): JsonResponse
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            return $this->naoEncontrado('Usuário não encontrado.');
        }

        $usuario->grupos()->detach($grupoId);

        return $this->sucesso([
            'grupos' => $usuario->grupos()->get(),
        ], 'Grupo removido do usuário com sucesso.');
    }

    public function adicionarPermissao(Request $request, int $usuarioId): JsonResponse
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            return $this->naoEncontrado('Usuário não encontrado.');
        }

        $request->validate([
            'permissao_id' => 'required|integer|exists:permissao,id',
            'tipo' => 'required|in:permitir,negar',
        ]);

        $usuario->permissoesIndividuais()->syncWithoutDetaching([
            $request->input('permissao_id') => ['tipo' => $request->input('tipo')],
        ]);

        return $this->sucesso([
            'permissoes_individuais' => $usuario->permissoesIndividuais()->get(),
        ], 'Permissão individual adicionada com sucesso.');
    }

    public function removerPermissao(int $usuarioId, int $permissaoId): JsonResponse
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            return $this->naoEncontrado('Usuário não encontrado.');
        }

        $usuario->permissoesIndividuais()->detach($permissaoId);

        return $this->sucesso([
            'permissoes_individuais' => $usuario->permissoesIndividuais()->get(),
        ], 'Permissão individual removida com sucesso.');
    }

    /**
     * Retorna permissões do usuário autenticado (sem middleware de permissão).
     */
    public function minhasPermissoes(): JsonResponse
    {
        $usuario = auth('api')->user();

        return $this->sucesso([
            'permissoes' => $usuario->obterPermissoes(),
            'modulos' => $usuario->obterPermissoesPorModulo(),
            'grupos' => $usuario->grupos()->ativos()->pluck('nome')->toArray(),
            'is_admin' => $usuario->isAdmin(),
        ]);
    }
}
