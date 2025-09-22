<?php

namespace App\Policies;

use App\Models\Dominio;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DominioPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Dominio $dominio): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Dominio $dominio): bool
    {
        return false;
    }

    public function delete(User $user, Dominio $dominio): bool
    {
        return false;
    }

    public function restore(User $user, Dominio $dominio): bool
    {
        return false;
    }

    public function forceDelete(User $user, Dominio $dominio): bool
    {
        return false;
    }
}
