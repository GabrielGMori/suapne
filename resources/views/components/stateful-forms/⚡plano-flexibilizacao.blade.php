<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Estudante;
use App\Models\Disciplina;
use App\Models\PlanoFlexibilizacaoCurricular;

new class extends Component {
    public ?PlanoFlexibilizacaoCurricular $planoFlexibilizacao = null;

    public array|string|int|null $estudanteId = null;
    public array $displayDisciplinas = [];
    public array $selectedDisciplinas = [];

    public function mount(?PlanoFlexibilizacaoCurricular $planoFlexibilizacao = null, mixed $estudanteId = null): void
    {
        $this->planoFlexibilizacao = $planoFlexibilizacao;

        $rawEstudanteId = old('estudante_id', $this->planoFlexibilizacao?->estudante_id ?? $estudanteId);
        $this->estudanteId = $this->getScalarEstudanteId($rawEstudanteId);

        $this->selectedDisciplinas = old('campos.componentesCurriculares', $this->planoFlexibilizacao?->campos['componentesCurriculares'] ?? []);

        $this->loadDisciplinas();
    }

    public function updatedEstudanteId($value): void
    {
        $this->estudanteId = $this->getScalarEstudanteId($value);
        // Do NOT clear $this->selectedDisciplinas here so selections persist
    }

    #[On('disciplina-created')]
    public function onDisciplinaCreated(int|string $id, ?string $nome = null): void
    {
        $disciplina = Disciplina::with('curso')->find($id);

        if ($disciplina) {
            $label = $disciplina->nome . ($disciplina->curso ? " - {$disciplina->curso->nome}" : '');
            $this->displayDisciplinas[(string) $id] = $label;

            $stringId = (string) $id;
            if (!in_array($stringId, $this->selectedDisciplinas, true)) {
                $this->selectedDisciplinas[] = $stringId;
            }
        }
    }

    public function selecionarDisciplinasDoCurso(): void
    {
        $id = $this->getScalarEstudanteId();
        if (!filled($id)) {
            return;
        }

        $estudante = Estudante::find($id);
        if (!$estudante) {
            return;
        }

        $this->selectedDisciplinas = Disciplina::where('curso_id', $estudante->curso_id)
            ->where('curso_periodo', $estudante->periodo)
            ->pluck('id')
            ->map(fn($discId) => (string) $discId)
            ->toArray();
    }

    private function loadDisciplinas(): void
    {
        $this->displayDisciplinas = Disciplina::with('curso')
            ->get()
            ->mapWithKeys(
                fn($disc) => [
                    (string) $disc->id => $disc->nome . ($disc->curso ? " - {$disc->curso->nome}" : ''),
                ],
            )
            ->toArray();
    }

    private function getScalarEstudanteId(mixed $value = null): ?string
    {
        $val = $value ?? $this->estudanteId;

        if (is_array($val)) {
            $val = reset($val) ?: null;
        }

        return filled($val) ? (string) $val : null;
    }

    #[Computed]
    public function estudanteOptions(): array
    {
        $currentYear = now()->year;

        return Estudante::with(['planosFlexibilizacaoCurricular' => fn($q) => $q->where('ano', $currentYear)])
            ->orderBy('nome')
            ->get()
            ->mapWithKeys(function ($estudante) {
                $semPlano = $estudante->planosFlexibilizacaoCurricular->isEmpty();
                $label = $estudante->nome . ($semPlano ? ' (Sem plano!)' : '');
                return [(string) $estudante->id => $label];
            })
            ->toArray();
    }
};
?>

@props(['planoFlexibilizacao' => null])

<form
    action="{{ $planoFlexibilizacao ? route('planos-flexibilizacao.update', $planoFlexibilizacao) : route('planos-flexibilizacao.store') }}"
    method="POST">
    @csrf
    @if ($planoFlexibilizacao)
        @method('PATCH')
    @endif

    <div>
        <div class="flex gap-5 mb-5">
            <h2 class="text-display-small">Período de realização:</h2>
            <x-form.input type="date" size="small" name="periodo_inicio" appearance="outlined" :value="old('periodo_inicio', $planoFlexibilizacao?->periodo_inicio?->format('Y-m-d'))" />
            <h2 class="text-display-small">a</h2>
            <x-form.input type="date" size="small" name="periodo_fim" appearance="outlined" :value="old('periodo_fim', $planoFlexibilizacao?->periodo_fim?->format('Y-m-d'))" />
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">1. Dados do estudante</h2>
            <livewire:form.select type="select" label="Estudante" name="estudante_id" appearance="outlined"
                size="large" placeholder="Selecionar"
                wire:key="estudante-select-{{ $planoFlexibilizacao?->id ?? 'new' }}" wire:model.live="estudanteId"
                :options="$this->estudanteOptions" />
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">2. Histórico de ações pedagógicas já realizadas e justificativa de
                implementação da flexibilização curricular</h2>
            <h3 class="text-body-large text-secondary-accent">(Registrar todas as ações pedagógicas e tentativas de
                adaptações realizadas até o momento)</h3>
            <x-form.input type="textarea" name="campos[acoesPedagogicas]" appearance="outlined" size="full"
                wire:ignore :value="old('campos.acoesPedagogicas', $planoFlexibilizacao?->campos['acoesPedagogicas'] ?? '')" />
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">3. Atendimento multiprofissional</h2>
            <h3 class="text-body-large text-secondary-accent">Profissionais, instituições ou serviços (internos ou
                externos ao IFPR) que fazem o acompanhamento do estudante</h3>
            <x-form.input type="textarea" name="campos[atendimentoMultiprofissional]" appearance="outlined"
                size="full" wire:ignore :value="old(
                    'campos.atendimentoMultiprofissional',
                    $planoFlexibilizacao?->campos['atendimentoMultiprofissional'] ?? '',
                )" />
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">4. Flexibilização Curricular, visando a implementação de 1 (uma) ou mais
                possibilidades</h2>

            <livewire:form.select wire:key="diferenciacao-curricular-select"
                label="I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE"
                name="campos[diferenciacaoCurricular]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" :value="old(
                    'campos.diferenciacaoCurricular',
                    $planoFlexibilizacao?->campos['diferenciacaoCurricular'] ?? '',
                )" />

            <livewire:form.select wire:key="atendimento-individualizado-select"
                label="II - Atendimento educacional individualizado realizado pelo professor do componente curricular"
                name="campos[atendimentoIndividualizado]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" :value="old(
                    'campos.atendimentoIndividualizado',
                    $planoFlexibilizacao?->campos['atendimentoIndividualizado'] ?? '',
                )" />

            <livewire:form.select wire:key="alteracao-prazo-select"
                label="III - Dilação ou redução do prazo para a conclusão do curso" name="campos[alteracaoPrazo]"
                appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" :value="old('campos.alteracaoPrazo', $planoFlexibilizacao?->campos['alteracaoPrazo'] ?? '')" />

            <livewire:form.select wire:key="reorganizacao-curricular-select"
                label="IV - Reorganização e/ou equivalência de componente curricular"
                name="campos[reorganizacaoCurricular]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" :value="old(
                    'campos.reorganizacaoCurricular',
                    $planoFlexibilizacao?->campos['reorganizacaoCurricular'] ?? '',
                )" />

            <livewire:form.select wire:key="criterios-diferenciados-select"
                label="V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes."
                name="campos[criteriosDiferenciados]" appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" :value="old(
                    'campos.criteriosDiferenciados',
                    $planoFlexibilizacao?->campos['criteriosDiferenciados'] ?? '',
                )" />
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">5. Componentes curriculares a serem flexibilizados</h2>
            <div class="flex items-center gap-5">
                <livewire:form.select type="multiselect" label="Componentes curriculares" placeholder="Selecionar"
                    appearance="outlined" name="campos[componentesCurriculares]" size="xlarge"
                    wire:key="disciplinas-select" wire:model.live="selectedDisciplinas" :options="$displayDisciplinas" />

                <livewire:modal.stateful.add-disciplina wire:key="add-disciplina-modal" />

                <x-button type="button" size="dynamic" label="Selecionar todos do curso do estudante selecionado"
                    color="secondary" wire:click="selecionarDisciplinasDoCurso" />
            </div>
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">6. Informações adicionais</h2>
            <x-form.input type="textarea" name="campos[informacoesAdicionais]" appearance="outlined" size="full"
                wire:ignore :value="old(
                    'campos.informacoesAdicionais',
                    $planoFlexibilizacao?->campos['informacoesAdicionais'] ?? '',
                )" />
        </div>

        <div class="flex justify-end gap-2">
            <x-button.cancel fallback="planos-flexibilizacao.index" />
            <x-button type="submit" :label="$planoFlexibilizacao ? 'Salvar Alterações' : 'Registrar'" />
        </div>
    </div>
</form>
