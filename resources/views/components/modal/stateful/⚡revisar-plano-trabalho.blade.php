<?php

use Livewire\Component;
use App\Models\PlanoTrabalhoEstudante;
use App\Enums\StatusPlanoTrabalhoEnum;
use App\Notifications\PlanoTrabalhoDevolvido;
use App\Notifications\PlanoTrabalhoAprovado;

new class extends Component {
    public PlanoTrabalhoEstudante $planoTrabalho;
    public string $devolvidoObservacao = '';

    public function devolver()
    {
        $this->validate(['devolvidoObservacao' => ['required', 'string', 'max:1000']]);

        $this->planoTrabalho->update([
            'status' => StatusPlanoTrabalhoEnum::DEVOLVIDO,
            'campos' => [...$this->planoTrabalho->campos, 'devolvidoObservacao' => $this->devolvidoObservacao],
        ]);
        $this->planoTrabalho->professor->notify(new PlanoTrabalhoDevolvido($this->planoTrabalho));
        $this->dispatch('refresh-page');
    }

    public function aprovar()
    {
        $this->planoTrabalho->update(['status' => StatusPlanoTrabalhoEnum::APROVADO]);
        $this->planoTrabalho->professor->notify(new PlanoTrabalhoAprovado($this->planoTrabalho));
        $this->dispatch('refresh-page');
    }
};
?>

<div class="flex gap-2">
    <x-modal name="devolver-modal" label="Devolver para retificação" color="red" title="Devolver para retificação">
        <x-form.input name="campos[devolvidoObservacao]" type="textarea" label="Adicionar observação"
        appearance="outlined" size="full" wire:model='devolvidoObservacao' :error="$errors->first('devolvidoObservacao')" />
        <div class="flex justify-end gap-3 mb-2">

            <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
            <x-button label="Devolver" color="red" wire:click="devolver" />
        </div>
    </x-modal>

    @if($planoTrabalho->status !== StatusPlanoTrabalhoEnum::APROVADO)
        <x-button label="Aprovar" wire:click="aprovar" />
    @endif
</div>
