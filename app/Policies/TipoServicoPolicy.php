<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TipoServico;

class TipoServicoPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->can('PERMITIR_TIPO_SERVICO_VISUALIZAR');
    }

    public function view(User $user, TipoServico $tipoServico): bool
    {
        // Lógica básica: pode ver se tem permissão
        if (!$user->can('PERMITIR_TIPO_SERVICO_VISUALIZAR')) {
            return false;
        }

        return true;
    }


    public function create(User $user): bool
    {
        return $user->can('PERMITIR_TIPO_SERVICO_CRIAR');
    }

    public function update(User $user, TipoServico $tipoServico): bool
    {
        // Verificar permissão básica
        if (!$user->can('PERMITIR_TIPO_SERVICO_EDITAR')) {
            return false;
        }

        // Lógica adicional: exemplo - não pode editar se excluído
        if ($tipoServico->isDeleted()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TipoServico $tipoServico): bool
    {
        if (!$user->can('PERMITIR_TIPO_SERVICO_EXCLUIR')) {
            return false;
        }

        // Lógica adicional: não pode excluir se já excluído
        return !$tipoServico->isDeleted();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TipoServico $tipoServico): bool
    {
        if (!$user->can('PERMITIR_TIPO_SERVICO_RESTAURAR')) {
            return false;
        }

        // Só pode restaurar se estiver excluído
        return $tipoServico->isDeleted();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TipoServico $tipoServico): bool
    {
        // Apenas super-admin pode deletar permanentemente
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can toggle status.
     */
    public function toggleStatus(User $user, TipoServico $tipoServico): bool
    {
        if (!$user->can('PERMITIR_TIPO_SERVICO_ALTERAR_STATUS')) {
            return false;
        }

        // Não pode alterar status se excluído
        return !$tipoServico->isDeleted();
    }
}
