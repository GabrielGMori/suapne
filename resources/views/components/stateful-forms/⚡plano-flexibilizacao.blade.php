<?php

use Livewire\Component;
use App\Models\Estudante;

new class extends Component {
    public null|string|array $estudanteId = '';
    public ?Estudante $estudante = null;

    public ?array $displayDisciplinas = null;
    public array $selectedDisciplinas = [];

    public function mount(): void
    {
        $this->estudanteId = old('estudante_id', $this->estudanteId ?? '');
        if (filled($this->estudanteId)) $this->updatedEstudanteId($this->estudanteId);
    }

    public function updatedEstudanteId($estId)
    {
        $id = is_array($estId) ? $estId[0] : $estId;
        $this->estudante = Estudante::find($id);

        $estudanteDisciplinas = $this->estudante?->disciplinas;
        $this->displayDisciplinas = $estudanteDisciplinas ? $estudanteDisciplinas->pluck('nome', 'id')->toArray() : [];
    }

};
?>

@props(['planoFlexibilizacao' => null])

<form action="{{ route('planos-flexibilizacao.store') }}" method="POST">
    @csrf

    <div>
        <div class="flex gap-5 mb-5">
            <h2 class="text-display-small">Período de realização:</h2>
            <x-form.input type="date" size="small" name="periodo_inicio" appearance="outlined"
                :value="$planoFlexibilizacao?->periodo_inicio->format('Y-m-d')" />
            <h2 class="text-display-small">a</h2>
            <x-form.input type="date" size="small" name="periodo_fim" appearance="outlined"
                :value="$planoFlexibilizacao?->periodo_fim->format('Y-m-d')" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">1. Dados do estudante</h2>
            <livewire:form.select type="select" label="Estudante" name="estudante_id" appearance="outlined" size="large"
                placeholder="Selecionar" :options="Estudante::all()->mapWithKeys(function ($estudante) {
                    $semPlano = $estudante->planosFlexibilizacaoCurricular->where('ano', now()->year)->isEmpty();
                    return [$estudante->id => $estudante->nome . ($semPlano ? ' (Sem plano!)' : ''),];
                })->toArray()"
                :value="$planoFlexibilizacao?->estudante_id" wire:model.live="estudanteId" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:ignore>
            <h2 class="text-display-small">2. Histórico de ações pedagógicas já realizadas e justificativa de
                implementação da flexibilização curricular</h2>
            <h3 class="text-body-large text-secondary-accent">(Registrar todas as ações pedagógicas e tentativas de
                adaptações realizadas até o momento)</h3>
            <x-form.input type="textarea" name="campos[acoesPedagogicas]" appearance="outlined" size="full" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:ignore>
            <h2 class="text-display-small">3. Atendimento multiprofissional</h2>
            <h3 class="text-body-large text-secondary-accent">Profissionais, instituições ou serviços (internos ou
                externos ao IFPR) que fazem o acompanhamento do estudante</h3>
            <x-form.input type="textarea" name="campos[atendimentoMultiprofissional]" appearance="outlined"
                size="full" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:ignore>
            <h2 class="text-display-small">4. Flexibilização Curricular, visando a impletenção de 1(uma) ou mais
                possibilidades</h2>
            <livewire:form.select
                label="I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE"
                name="campos[diferenciacaoCurricular]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
            <livewire:form.select
                label="II - Atendimento educacional individualizado realizado pelo professor do componente curricular"
                name="campos[atendimentoIndividualizado]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
            <livewire:form.select label="III - Dilação ou redução do prazo para a conclusão do curso"
                name="campos[alteracaoPrazo]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
            <livewire:form.select label="IV - Reorganização e/ou equivalência de componente curricular"
                name="campos[reorganizacaoCurricular]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
            <livewire:form.select
                label="V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes."
                name="campos[criteriosDiferenciados]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">5. Componentes curriculares a serem flexibilizados</h2>
            <div class="flex items-center gap-5" wire:key="disciplinas-select-wrapper">
                <livewire:form.select type="multiselect" label="Componentes curriculares" placeholder="Selecionar"
                appearance="outlined" name="campos[componentesCurriculares]" :disabled="$estudante === null"
                :placeholder="$estudante !== null ? 'Selecionar' : 'Escolha um estudante'" :options="$displayDisciplinas ?? []"
                wire:key="disciplinas-select-{{ $this->estudante?->id }}" wire:model.live="selectedDisciplinas" />
                <x-button type="button" size="dynamic" label="Selecionar todos" color="secondary"
                    x-on:click="$dispatch('select-all', { name: 'campos[componentesCurriculares]' })" />
            </div>
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:ignore>
            <h2 class="text-display-small">6. Informações adicionais</h2>
            <x-form.input type="textarea" name="campos[informacoesAdicionais]" appearance="outlined"
                size="full" />
        </div>
        <div class="flex justify-end gap-2">
            <x-button.cancel fallback="planos-flexibilizacao.index" />
            <x-button type="submit" label="Registrar" />
        </div>
    </div>
</form>
