<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transacao;

class TransacaoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('PERMITIR_TRANSACAO_VISUALIZAR');
    }

    public function view(User $user, Transacao $transacao): bool
    {
        return $user->hasPermissionTo('PERMITIR_TRANSACAO_VISUALIZAR');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('PERMITIR_TRANSACAO_CRIAR');
    }

    public function update(User $user, Transacao $transacao): bool
    {
        return $user->hasPermissionTo('PERMITIR_TRANSACAO_EDITAR');
    }

    public function delete(User $user, Transacao $transacao): bool
    {
        return $user->hasPermissionTo('PERMITIR_TRANSACAO_EXCLUIR');
    }

    public function pagar(User $user, Transacao $transacao): bool
    {
        return $user->hasPermissionTo('PERMITIR_TRANSACAO_PAGAR');
    }

    public function cancelar(User $user, Transacao $transacao): bool
    {
        return $user->hasPermissionTo('PERMITIR_TRANSACAO_CANCELAR');
    }
}
