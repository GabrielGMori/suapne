<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\AtendimentoSemanal;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use function in_array;

class AtendimentoSemanalPolicy
{
    private array $alwaysCheck = ['forceDelete', 'update'];

    public function before(User $user, string $ability): bool|null
    {
        if (in_array($ability, $this->alwaysCheck)) {
            return null;
        }
        return $user->role === RoleEnum::DOCENTE_ESPECIAL ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->role === RoleEnum::TECNICO;
    }

    public function view(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return $atendimentoSemanal->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === RoleEnum::TECNICO;
    }

    public function update(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return $atendimentoSemanal->user_id === $user->id;
    }

    public function delete(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return $atendimentoSemanal->user_id === $user->id;
    }

    public function restore(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return $user->role === RoleEnum::TECNICO;
    }

    public function forceDelete(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return false;
    }
}
