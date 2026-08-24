<?php

namespace App\Policies;

use App\Models\EntrevistaFamiliar;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Auth\Access\Response;

class EntrevistaFamiliarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
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

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EntrevistaFamiliar $entrevistaFamiliar): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EntrevistaFamiliar $entrevistaFamiliar): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EntrevistaFamiliar $entrevistaFamiliar): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EntrevistaFamiliar $entrevistaFamiliar): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EntrevistaFamiliar $entrevistaFamiliar): bool
    {
        return false;
    }
}
