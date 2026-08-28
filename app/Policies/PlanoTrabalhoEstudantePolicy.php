<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\User;

class PlanoTrabalhoEstudantePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($ability === 'forceDelete') {
            return false;
        }

        return $user->role === RoleEnum::DOCENTE_ESPECIAL ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, PlanoTrabalhoEstudante $planoTrabalhoEstudante): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, PlanoTrabalhoEstudante $planoTrabalhoEstudante): bool
    {
        return false;
    }

    public function delete(User $user, PlanoTrabalhoEstudante $planoTrabalhoEstudante): bool
    {
        return false;
    }

    public function restore(User $user, PlanoTrabalhoEstudante $planoTrabalhoEstudante): bool
    {
        return false;
    }

    public function forceDelete(User $user, PlanoTrabalhoEstudante $planoTrabalhoEstudante): bool
    {
        return false;
    }
}
