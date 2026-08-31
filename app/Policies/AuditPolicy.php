<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;
use function in_array;

class AuditPolicy
{
    private array $alwaysCheck = ['forceDelete', 'create', 'update', 'delete', 'restore'];

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

    public function view(User $user, Audit $audit): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Audit $audit): bool
    {
        return false;
    }

    public function delete(User $user, Audit $audit): bool
    {
        return false;
    }

    public function restore(User $user, Audit $audit): bool
    {
        return false;
    }

    public function forceDelete(User $user, Audit $audit): bool
    {
        return false;
    }
}
