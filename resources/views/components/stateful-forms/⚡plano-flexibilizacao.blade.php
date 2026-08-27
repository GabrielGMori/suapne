<?php

use Livewire\Component;
use App\Models\Estudante;
use Illuminate\Database\Eloquent\Collection as DatabaseCollection;

new class extends Component {
    public string|array $estudanteId = '';
    public ?Estudante $estudante = null;
    public ?array $disciplinas = null;

    public function mount(): void
    {
        $this->estudanteId = old('estudante_id', $this->estudanteId);

        if ($this->estudanteId !== '' && $this->estudanteId !== []) {
            $this->updatedEstudanteId();
        }
    }

    public function loadDisciplinas(): void
    {
        $estudanteDisciplinas = $this->estudante?->curso->disciplinas;
        $this->disciplinas = $estudanteDisciplinas ? $estudanteDisciplinas->mapWithKeys(fn($disc) => [$disc->id => $disc->nome . " - " . $disc->curso->nome])->toArray() : [];
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
            <livewire:form.select type="select" label="Estudante" name="estudante_id" appearance="outlined" size="large"
                placeholder="Selecionar" :options="Estudante::all()->mapWithKeys(function ($estudante) {
                    $semPlano = $estudante->planosFlexibilizacaoCurricular->where('ano', now()->year)->isEmpty();
                    return [$estudante->id => $estudante->nome . ($semPlano ? ' (Sem plano!)' : ''),];
                })->toArray()"
                :value="$planoFlexibilizacao?->estudante_id" wire:model.live="estudanteId" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">2. Histórico de ações pedagógicas já realizadas e justificativa de
                implementação da flexibilização curricular</h2>
            <h3 class="text-body-large text-secondary-accent">(Registrar todas as ações pedagógicas e tentativas de
                adaptações realizadas até o momento)</h3>
            <livewire:form.input type="textarea" name="campos[acoesPedagogicas]" appearance="outlined" size="full" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">3. Atendimento multiprofissional</h2>
            <h3 class="text-body-large text-secondary-accent">Profissionais, instituições ou serviços (internos ou
                externos ao IFPR) que fazem o acompanhamento do estudante</h3>
            <livewire:form.input type="textarea" name="campos[atendimentoMultiprofissional]" appearance="outlined"
                size="full" />
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
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
            <livewire:form.select type="multiselect" label="Componentes curriculares" placeholder="Selecionar"
                appearance="outlined" name="campos[componentesCurriculares]" :disabled="$estudante === null" size="xlarge"
                :placeholder="$estudante !== null ? 'Selecionar' : 'Escolha um estudante'" :options="$this->disciplinas ?? []" />
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">6. Informações adicionais</h2>
            <livewire:form.input type="textarea" name="campos[informacoesAdicionais]" appearance="outlined"
                size="full" />
        </div>
        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link"
                href="{{ url()->previous() !== url()->current() ? url()->previous() : route('planos-flexibilizacao.index') }}"
                color="red" />
            <x-button type="submit" label="Registrar" />
        </div>
    </div>
</form>
