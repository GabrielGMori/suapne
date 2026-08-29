<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Estudante;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use function in_array;

class EstudantePolicy
{
    private array $alwaysCheck = ['forceDelete'];

    public function before(User $user, string $ability): bool|null
    {
        if (in_array($ability, $this->alwaysCheck)) {
            return false;
        }
        return $user->role === RoleEnum::DOCENTE_ESPECIAL ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Estudante $estudante): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === RoleEnum::TECNICO;
    }

    public function update(User $user, Estudante $estudante): bool
    {
        return $user->role === RoleEnum::TECNICO;
    }

    public function delete(User $user, Estudante $estudante): bool
    {
        return false;
    }

    public function restore(User $user, Estudante $estudante): bool
    {
        return false;
    }

    public function forceDelete(User $user, Estudante $estudante): bool
    {
        return false;
    }
}
