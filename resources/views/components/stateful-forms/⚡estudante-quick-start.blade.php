<?php

use Livewire\Component;
use App\Models\Estudante;
use App\Models\AtendimentoSemanal;
use App\Models\PlanoTrabalhoEstudante;

new class extends Component {
    public null|string|array $estudanteId = '';
    public ?Estudante $estudante = null;

    public function mount(): void
    {
        $this->estudanteId = old('estudante_id', $this->estudanteId ?? '');
    }

    public function updatedEstudanteId($estId)
    {
        $id = is_array($estId) ? $estId[0] : $estId;
        $this->estudante = Estudante::find($id);
    }
};
?>

<div class="space-y-5 col-span-2 xl:col-span-1">
    @can('create', AtendimentoSemanal::class)
        <x-icon icon="article_person" size="40" label="Iniciar atendimento semanal" />

        <div class="flex items-center gap-4 mb-15">
            <div class="w-full max-w-sm">
                <livewire:form.select label="Estudante" appearance="outlined" size="full" name="estudante_id"
                    :options="App\Models\Estudante::pluck('nome', 'id')->toArray()" wire:model.live="estudanteId" />
            </div>
            <x-button label="Iniciar atendimento" type="link" href="{{route('atendimentos.create', ['estudante' => $estudante])}}" />
        </div>
    @endcan

    @can('create', PlanoTrabalhoEstudante::class)
        <x-icon icon="assignment_add" size="40" label="Criar plano de trabalho do estudante" />

        <div class="flex items-center gap-4">
            <div class="w-full max-w-sm">
                <livewire:form.select label="Estudante" appearance="outlined" size="full" name="estudante_id"
                    :options="App\Models\Estudante::pluck('nome', 'id')->toArray()" wire:model.live="estudanteId" />
            </div>
            <x-button label="Criar PTE" type="link" href="{{route('planos-trabalho.create', ['estudante' => $estudante])}}" />
        </div>
    @endcan
</div>
