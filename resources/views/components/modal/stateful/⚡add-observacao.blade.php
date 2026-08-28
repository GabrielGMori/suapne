<?php

namespace App\Livewire\Modal\Stateful;

use App\Models\Estudante;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public Estudante $estudante;

    public string $observacao = '';

    public function save(): void
    {
        $this->validate([
            'observacao' => ['required', 'string', 'max:1000'],
        ]);

        $this->estudante->observacoes()->create([
            'observacao' => $this->observacao,
            'user_id' => Auth::user()->id,
        ]);

        $this->reset('observacao');
        $this->dispatch('close-modal', 'modal-observacoes');
        $this->dispatch('observacao-added');
        $this->dispatch('refresh-page');
    }
};
?>

<div>
    <x-modal name="modal-observacoes" title="Adicionar observação" icon="add" color="transparent" width="2xl">
        <form wire:submit="save">

            <x-form.input type="textarea" name="observacao" label="Nova observação" appearance="outlined" size="full"
                wire:model="observacao" :error="$errors->first('observacao')" />

            <div class="flex justify-end gap-3 mt-4 mb-2">
                <x-button label="Cancelar" color="secondary" type="button" x-on:click="show = false" />
                <x-button label="Adicionar" type="submit" color="primary" />
            </div>
        </form>
    </x-modal>
</div>
