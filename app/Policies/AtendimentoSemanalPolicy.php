<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\AtendimentoSemanal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AtendimentoSemanalPolicy
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

    public function view(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return false;
    }

    public function delete(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return false;
    }

    public function restore(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return false;
    }

    public function forceDelete(User $user, AtendimentoSemanal $atendimentoSemanal): bool
    {
        return false;
    }
}
