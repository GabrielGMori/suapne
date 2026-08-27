<?php

use Livewire\Component;
use App\Models\Estudante;

new class extends Component {
    public string|array $estudanteId = '';
    public ?Estudante $estudante = null;

    public ?string $perfil = "";

    public function mount(): void
    {
        $this->estudanteId = old('estudante_id', $this->estudanteId);

        $oldPerfil = old('campos.perfilDoEstudante');
        if ($oldPerfil !== null) {
            $this->perfil = $oldPerfil;
        } elseif ($this->estudanteId !== '' && $this->estudanteId !== []) {
            $this->updatedEstudanteId();
        }
    }

    public function loadPerfil(): void
    {
        $ultimoAtendimento = $this->estudante->atendimentosSemanais()->latest()->first();
        $this->perfil = $ultimoAtendimento ? ($ultimoAtendimento->campos['perfilDoEstudante'] ?? '') : '';
    }

    public function updatedEstudanteId()
    {
        $id = is_array($this->estudanteId) ? $this->estudanteId[0] : $this->estudanteId;
        $this->estudante = Estudante::find($id);
        $this->loadPerfil();
    }
};
?>

@props(['atendimento' => null])

<form action="{{ route('atendimentos.store') }}" method="POST">
    @csrf
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>

        <livewire:form.select label="Estudante" name="estudante_id" appearance="outlined" placeholder="Selecionar"
            wire:model.live="estudanteId" :options="Estudante::pluck('nome', 'id')->toArray()"
            :value="$atendimento?->estudante_id" />

        <x-form.input type="text" label="Local" appearance="outlined" size="small" name="local"
            :value="$atendimento?->local" />

        <x-form.input type="datetime" label="Dia" appearance="outlined" name="data"
            :value="$atendimento?->data->format('Y-m-d H:i:s')" />

        <x-form.input type="textarea" label="Perfil do Estudante" appearance="outlined"
            name="campos[perfilDoEstudante]" size="full" wire:model.live="perfil" />
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Registro do Atendimento</h2>
        <x-form.input type="textarea" name="campos[registroDoAtendimento]" appearance="outlined" size="full" />
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Encaminhamentos</h2>
        <x-form.input type="textarea" name="campos[encaminhamentos]" appearance="outlined" size="full" />
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Observações adicionais</h2>
        <x-form.input type="textarea" name="campos[observacoesAdicionais]" appearance="outlined" size="full" />
    </div>
    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" type="link"
            href="{{ url()->previous() !== url()->current() ? url()->previous() : route('atendimentos.index') }}"
            color="red" />
        <x-button type="submit" label="Registrar" />
    </div>
</form>
