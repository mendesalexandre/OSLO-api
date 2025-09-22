<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Dominio;

class DominioPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('PERMITIR_DOMINIO_VISUALIZAR');
    }

    public function view(User $user, Dominio $dominio): bool
    {
        return $user->can('PERMITIR_DOMINIO_VISUALIZAR');
    }

    public function create(User $user): bool
    {
        return $user->can('PERMITIR_DOMINIO_CRIAR');
    }

    public function update(User $user, Dominio $dominio): bool
    {
        return $user->can('PERMITIR_DOMINIO_EDITAR');
    }

    public function delete(User $user, Dominio $dominio): bool
    {
        return $user->can('PERMITIR_DOMINIO_EXCLUIR');
    }

    public function restore(User $user, Dominio $dominio): bool
    {
        return $user->can('PERMITIR_DOMINIO_RESTAURAR');
    }
}
