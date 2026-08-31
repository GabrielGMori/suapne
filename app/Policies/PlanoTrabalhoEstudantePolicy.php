<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\User;
use function in_array;

class PlanoTrabalhoEstudantePolicy
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

    public function view(User $user, PlanoTrabalhoEstudante $planoTrabalhoEstudante): bool
    {
        return $user->role === RoleEnum::TECNICO || $planoTrabalhoEstudante->user_professor_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === RoleEnum::TECNICO;
    }

    public function update(User $user, PlanoTrabalhoEstudante $planoTrabalhoEstudante): bool
    {
        return $planoTrabalhoEstudante->user_id === $user->id || $planoTrabalhoEstudante->user_professor_id === $user->id;
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
