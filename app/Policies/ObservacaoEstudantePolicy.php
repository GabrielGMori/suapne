<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\ObservacaoEstudante;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ObservacaoEstudantePolicy
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
        return true;
    }

    public function view(User $user, ObservacaoEstudante $observacaoEstudante): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ObservacaoEstudante $observacaoEstudante): bool
    {
        return false;
    }

    public function delete(User $user, ObservacaoEstudante $observacaoEstudante): bool
    {
        return $observacaoEstudante->user_id === $user->id;
    }

    public function restore(User $user, ObservacaoEstudante $observacaoEstudante): bool
    {
        return false;
    }

    public function forceDelete(User $user, ObservacaoEstudante $observacaoEstudante): bool
    {
        return false;
    }
}
