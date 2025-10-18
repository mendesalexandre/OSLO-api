<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Caixa;

class CaixaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_VISUALIZAR');
    }

    public function view(User $user, Caixa $caixa): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_VISUALIZAR');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_CRIAR');
    }

    public function update(User $user, Caixa $caixa): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_EDITAR');
    }

    public function delete(User $user, Caixa $caixa): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_EXCLUIR');
    }
}
