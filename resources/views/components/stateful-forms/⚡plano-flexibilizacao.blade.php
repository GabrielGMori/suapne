<?php

use Livewire\Component;
use App\Models\Estudante;
use Illuminate\Database\Eloquent\Collection as DatabaseCollection;

new class extends Component {
    public string|array $estudanteId = '';
    public ?Estudante $estudante = null;
    public ?DatabaseCollection $disciplinas = null;

    public function loadDisciplinas(): void
    {
        $this->disciplinas = $this->estudante ? $this->estudante->curso->disciplinas : collect();
    }

    public function updatedEstudanteId()
    {
        $id = is_array($this->estudanteId) ? $this->estudanteId[0] : $this->estudanteId;
        $this->estudante = Estudante::find($id);
        $this->loadDisciplinas();
    }
};
?>

@props(['planoFlexibilizacao' => null])

<form action="{{ route('planos-flexibilizacao.store') }}" method="POST">
    @csrf
    <div>
        <div class="flex gap-5 mb-5">
            <h2 class="text-display-small">Período de realização:</h2>
            <livewire:form.input type="date" size="small" name="periodo_inicio" appearance="outlined"
                :value="$planoFlexibilizacao?->periodo_inicio->format('Y-m-d')" />
            <h2 class="text-display-small">a</h2>
            <livewire:form.input type="date" size="small" name="periodo_fim" appearance="outlined"
                :value="$planoFlexibilizacao?->periodo_fim->format('Y-m-d')" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">1. Dados do estudante</h2>
            <livewire:form.select type="select" label="Estudante" name="estudante_id" appearance="outlined"
                placeholder="Selecionar" :options="Estudante::pluck('nome', 'id')->toArray()" :value="$planoFlexibilizacao?->estudante_id" wire:model.live="estudanteId" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">2. Histórico de ações pedagógicas já realizadas e justificativa de
                implementação da flexibilização curricular</h2>
            <h3 class="text-body-large text-secondary-accent">(Registrar todas as ações pedagógicas e tentativas de
                adaptações realizadas até o momento)</h3>
            <livewire:form.input type="textarea" name="campos[acoesPedagogicas]" appearance="outlined" size="full"
                value="{{ old('campos.acoesPedagogicas') }}" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">3. Atendimento multiprofissional</h2>
            <h3 class="text-body-large text-secondary-accent">Profissionais, instituições ou serviços (internos ou
                externos ao IFPR) que fazem o acompanhamento do estudante</h3>
            <livewire:form.input type="textarea" name="campos[atendimentoMultiprofissional]" appearance="outlined"
                size="full" value="{{ old('campos.atendimentoMultiprofissional') }}" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">4. Flexibilização Curricular, visando a impletenção de 1(uma) ou mais
                possibilidades</h2>
            <livewire:form.select
                label="I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE"
                name="campos[diferenciacaoCurricular]" appearance="outlined"
                value="{{ old('campos.diferenciacaoCurricular') }}" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
            <livewire:form.select
                label="II - Atendimento educacional individualizado realizado pelo professor do componente curricular"
                name="campos[atendimentoIndividualizado]" appearance="outlined"
                value="{{ old('campos.atendimentoIndividualizado') }}" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
            <livewire:form.select label="III - Dilação ou redução do prazo para a conclusão do curso"
                name="campos[alteracaoPrazo]" appearance="outlined" value="{{ old('campos.alteracaoPrazo') }}"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" />
            <livewire:form.select label="IV - Reorganização e/ou equivalência de componente curricular"
                name="campos[reorganizacaoCurricular]" appearance="outlined"
                value="{{ old('campos.reorganizacaoCurricular') }}" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
            <livewire:form.select
                label="V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes."
                name="campos[criteriosDiferenciados]" appearance="outlined"
                value="{{ old('campos.criteriosDiferenciados') }}" :options="['Sim' => 'Sim', 'Não' => 'Não']" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">5. Componentes curriculares a serem flexibilizados</h2>
            <livewire:form.select type="multiselect" label="Componentes curriculares" placeholder="Selecionar"
                appearance="outlined" :value="old('campos.componentesCurriculares')" name="campos[componentesCurriculares]" 
                :disabled="$estudante === null"
                :placeholder="$estudante !== null ? 'Selecionar' : 'Escolha um estudante'" 
                :reactiveOptions="$this->disciplinas?->mapWithKeys(fn($disciplina) => [$disciplina->id => $disciplina->nome])->toArray() ?? []" />
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">6. Informações adicionais</h2>
            <livewire:form.input type="textarea" name="campos[informacoesAdicionais]" appearance="outlined"
                size="full" value="{{ old('campos.informacoesAdicionais') }}" />
        </div>
        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link"
                href="{{ url()->previous() !== url()->current() ? url()->previous() : route('planos-flexibilizacao.index') }}"
                color="red" />
            <x-button type="submit" label="Registrar" />
        </div>
    </div>
</form>
