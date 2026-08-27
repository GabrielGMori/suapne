<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Disciplina;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DisciplinaPolicy
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

    public function view(User $user, Disciplina $disciplina): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Disciplina $disciplina): bool
    {
        return false;
    }

    public function delete(User $user, Disciplina $disciplina): bool
    {
        return false;
    }

    public function restore(User $user, Disciplina $disciplina): bool
    {
        return false;
    }

    public function forceDelete(User $user, Disciplina $disciplina): bool
    {
        return false;
    }
}
