<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\TemplateFormulario;
use App\Models\User;
use function in_array;

class TemplateFormularioPolicy
{
    private array $alwaysCheck = ['forceDelete'];

    private array $protegidoNoPadrao = ['update', 'delete'];

    public function before(User $user, string $ability, mixed $alvo = null): bool|null
    {
        if (in_array($ability, $this->alwaysCheck)) {
            return false;
        }

        if ($alvo instanceof TemplateFormulario && $alvo->padrao && in_array($ability, $this->protegidoNoPadrao, true)) {
            return false;
        }

        return $user->role === RoleEnum::DOCENTE_ESPECIAL ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, TemplateFormulario $templateFormulario): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, TemplateFormulario $templateFormulario): bool
    {
        return false;
    }

    public function delete(User $user, TemplateFormulario $templateFormulario): bool
    {
        return false;
    }

    public function restore(User $user, TemplateFormulario $templateFormulario): bool
    {
        return false;
    }

    public function forceDelete(User $user, TemplateFormulario $templateFormulario): bool
    {
        return false;
    }
}
