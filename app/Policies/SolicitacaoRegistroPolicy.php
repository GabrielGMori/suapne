<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\SolicitacaoRegistro;
use App\Models\User;
use function in_array;

class SolicitacaoRegistroPolicy
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
        return false;
    }

    public function view(User $user, SolicitacaoRegistro $solicitacaoRegistro): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, SolicitacaoRegistro $solicitacaoRegistro): bool
    {
        return false;
    }

    public function delete(User $user, SolicitacaoRegistro $solicitacaoRegistro): bool
    {
        return false;
    }

    public function restore(User $user, mixed $solicitacaoRegistro = null): bool
    {
        return false;
    }

    public function forceDelete(User $user, mixed $solicitacaoRegistro = null): bool
    {
        return false;
    }
}
