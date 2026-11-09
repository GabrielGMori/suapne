<?php

namespace App\Livewire\Concerns;

use App\Support\CamposTemplate;
use Livewire\Attributes\Computed;

trait GerenciaCamposAdicionais
{
    abstract protected function contextoCampos(): array;

    #[Computed]
    public function camposDoFormulario(): array
    {
        [$tipo, $templateId, $registro] = $this->contextoCampos();

        return CamposTemplate::camposParaFormulario($tipo, $templateId, $registro, (array) old('campos', $registro?->campos ?? []));
    }

    public function numeroDoCampo(string $chave): ?int
    {
        return CamposTemplate::numeracao($this->contextoCampos()[0], $this->camposDoFormulario)[$chave] ?? null;
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
}
