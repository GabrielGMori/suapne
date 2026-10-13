<?php

namespace App\Livewire\Modal\Stateful;

use App\Models\Disciplina;
use App\Models\Curso;
use App\Http\Requests\DisciplinaRequest;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

new class extends Component {
    public string $nome = '';
    public string $ementa = '';
    public ?string $curso_id = null;
    public ?int $curso_periodo = null;

    public function save(): void
    {
        Gate::authorize('create', Disciplina::class);

        $formRequest = DisciplinaRequest::createFrom(request());
        $formRequest->merge([
            'nome' => $this->nome,
            'ementa' => $this->ementa,
            'curso_id' => intval($this->curso_id),
            'curso_periodo' => $this->curso_periodo,
        ]);

        $validated = $this->validate($formRequest->rules());

        $disciplina = Disciplina::create($validated);

        $this->reset(['nome', 'ementa', 'curso_id', 'curso_periodo']);
        $this->dispatch('close-modal', 'modal-add-disciplina');
        $this->dispatch('disciplina-created', id: $disciplina->id, nome: $disciplina->nome);
    }
};
?>

<x-modal name="modal-add-disciplina" title="Nova disciplina" icon="add" color="secondary" width="2xl" {{ $attributes }}>
    <div wire:keydown.enter="save">
        <x-form.input type="text" name="nome" label="Nome" appearance="outlined" size="full" wire:model="nome" />

        <livewire:form.select type="select" label="Curso" name="curso_id" appearance="outlined" placeholder="Selecionar"
            :options="Curso::pluck('nome', 'id')->toArray()" wire:model="curso_id" size="large"
            wire:key="add-disciplina-curso-select" :parentError="$errors->first('curso_id')" />

        <x-form.input type="number" name="curso_periodo" label="Período no curso" appearance="outlined" size="small"
            wire:model="curso_periodo" />

        <x-form.input type="textarea" name="ementa" label="Ementa" appearance="outlined" size="full" wire:model="ementa" />

        <div class="flex justify-end gap-3 mt-4 mb-2">
            <x-button label="Cancelar" color="secondary" type="button" x-on:click="show = false" />
            <x-button label="Adicionar" type="button" color="primary" wire:click="save" />
        </div>
    </div>
</x-modal>
