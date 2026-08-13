<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlanoFlexibilizacaoCurricularPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($ability === 'forceDelete') {
            return false;
        }
        return $user->role === RoleEnum::DOCENTE_ESPECIAL ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanoFlexibilizacaoCurricular $planoFlexibilizacaoCurricular): bool
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
    public function update(User $user, PlanoFlexibilizacaoCurricular $planoFlexibilizacaoCurricular): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanoFlexibilizacaoCurricular $planoFlexibilizacaoCurricular): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PlanoFlexibilizacaoCurricular $planoFlexibilizacaoCurricular): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PlanoFlexibilizacaoCurricular $planoFlexibilizacaoCurricular): bool
    {
        return false;
    }
}
