<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Enums\TipoFormularioEnum;
use App\Models\ModeloFormulario;
use App\Models\User;
use function in_array;

class ModeloFormularioPolicy
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

    public function view(User $user, ModeloFormulario $modeloFormulario): bool
    {
        return $this->update($user, $modeloFormulario);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ModeloFormulario $modeloFormulario): bool
    {
        if ($modeloFormulario->estudante_id === null) {
            return false;
        }

        return match ($user->role) {
            RoleEnum::TECNICO => true,
            RoleEnum::PROFESSOR_REGULAR => $modeloFormulario->tipo === TipoFormularioEnum::PLANO_TRABALHO
                && $user->planosTrabalhoProfessor()->where('estudante_id', $modeloFormulario->estudante_id)->exists(),
            default => false,
        };
    }

    public function delete(User $user, ModeloFormulario $modeloFormulario): bool
    {
        return false;
    }

    public function restore(User $user, ModeloFormulario $modeloFormulario): bool
    {
        return false;
    }

    public function forceDelete(User $user, ModeloFormulario $modeloFormulario): bool
    {
        return false;
    }
}
