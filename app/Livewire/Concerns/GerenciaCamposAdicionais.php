<?php

namespace App\Livewire\Concerns;

use App\Support\CamposTemplate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

trait GerenciaCamposAdicionais
{
    abstract protected function contextoCampos(): array;

    #[Computed]
    public function camposDoFormulario(): array
    {
        [$tipo, $templateId, $registro] = $this->contextoCampos();

        return CamposTemplate::camposParaFormulario($tipo, $templateId, $registro, (array) old('campos', $registro?->campos ?? []));
    }

    public function campoAtivo(string $chave): bool
    {
        return $this->campoDoFormulario($chave) !== null;
    }

    public function campoDoFormulario(string $chave): ?array
    {
        foreach ($this->camposDoFormulario as $campo) {
            if ($campo['chave'] === $chave) {
                return $campo;
            }
        }

        return null;
    }

    #[On('campos-alterados')]
    public function camposAlterados(): void
    {
        unset($this->camposDoFormulario);
    }
}
