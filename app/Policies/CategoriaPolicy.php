<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Categoria;

class CategoriaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('PERMITIR_CATEGORIA_VISUALIZAR');
    }

    public function view(User $user, Categoria $categoria): bool
    {
        return $user->hasPermissionTo('PERMITIR_CATEGORIA_VISUALIZAR');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('PERMITIR_CATEGORIA_CRIAR');
    }

    public function update(User $user, Categoria $categoria): bool
    {
        return $user->hasPermissionTo('PERMITIR_CATEGORIA_EDITAR');
    }

    public function delete(User $user, Categoria $categoria): bool
    {
        return $user->hasPermissionTo('PERMITIR_CATEGORIA_EXCLUIR');
    }
}
