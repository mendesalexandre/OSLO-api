<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CaixaMovimento;

class CaixaMovimentoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_MOVIMENTO_VISUALIZAR');
    }

    public function view(User $user, CaixaMovimento $movimento): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_MOVIMENTO_VISUALIZAR');
    }

    public function abrir(User $user): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_MOVIMENTO_ABRIR');
    }

    public function fechar(User $user, CaixaMovimento $movimento): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_MOVIMENTO_FECHAR');
    }

    public function conferir(User $user, CaixaMovimento $movimento): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_MOVIMENTO_CONFERIR');
    }

    public function reabrir(User $user, CaixaMovimento $movimento): bool
    {
        return $user->hasPermissionTo('PERMITIR_CAIXA_MOVIMENTO_REABRIR');
    }
}
