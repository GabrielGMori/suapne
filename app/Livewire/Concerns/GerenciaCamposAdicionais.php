<?php

namespace App\Livewire\Concerns;

use App\Models\ModeloFormulario;
use App\Support\FormularioPadrao;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

trait GerenciaCamposAdicionais
{
    abstract protected function contextoCampos(): array;

    #[Computed]
    public function camposDoFormulario(): array
    {
        [$tipo, $estudanteId, $registro] = $this->contextoCampos();

        return FormularioPadrao::camposParaFormulario($tipo, $estudanteId, $registro, (array) old('campos', $registro?->campos ?? []));
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

    public function podeEditarCampos(): bool
    {
        [$tipo, $estudanteId] = $this->contextoCampos();

        return $estudanteId !== null && Gate::allows('update', ModeloFormulario::para($tipo, $estudanteId));
    }

    public function removerCampo(string $chave): void
    {
        abort_unless($this->podeEditarCampos(), 403);

        [$tipo, $estudanteId] = $this->contextoCampos();

        ModeloFormulario::para($tipo, $estudanteId)->remover($chave);

        unset($this->camposDoFormulario);
        $this->dispatch('campos-alterados');
    }

    #[On('campos-alterados')]
    public function camposAlterados(): void
    {
        unset($this->camposDoFormulario);
    }
}
