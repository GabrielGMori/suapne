<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use function in_array;

class CursoPolicy
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

    public function view(User $user, Curso $curso): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Curso $curso): bool
    {
        return false;
    }

    public function delete(User $user, Curso $curso): bool
    {
        return false;
    }

    public function restore(User $user, Curso $curso): bool
    {
        return false;
    }

    public function forceDelete(User $user, Curso $curso): bool
    {
        return false;
    }
}
