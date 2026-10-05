<?php

namespace App\Policies;

use App\Models\EntrevistaFamiliar;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Auth\Access\Response;
use function in_array;

class EntrevistaFamiliarPolicy
{
    private array $alwaysCheck = ['forceDelete'];

    public function before(User $user, string $ability): bool|null
    {
        if (in_array($ability, $this->alwaysCheck)) {
            return null;
        }
        return $user->role === RoleEnum::DOCENTE_ESPECIAL ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, EntrevistaFamiliar $entrevistaFamiliar): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, EntrevistaFamiliar $entrevistaFamiliar): bool
    {
        return false;
    }

    public function delete(User $user, EntrevistaFamiliar $entrevistaFamiliar): bool
    {
        return false;
    }

    public function restore(User $user, mixed $entrevistaFamiliar = null): bool
    {
        return false;
    }

    public function forceDelete(User $user, mixed $entrevistaFamiliar = null): bool
    {
        return false;
    }
}
