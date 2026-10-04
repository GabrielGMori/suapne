<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Estudante;
use App\Models\Disciplina;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\TemplateFormulario;
use App\Enums\TipoFormularioEnum;

new class extends Component {
    public ?PlanoTrabalhoEstudante $planoTrabalho = null;

    public array|string|int|null $estudanteId = null;
    public array|string|int|null $templateId = null;
    public ?Estudante $estudante = null;

    public array $displayDisciplinas = [];
    public array $selectedDisciplinas = [];

    public array $displayProfessores = [];
    public array $selectedProfessores = [];

    public function mount(?PlanoTrabalhoEstudante $planoTrabalho = null): void
    {
        $this->planoTrabalho = $planoTrabalho;

        $this->loadDisciplinas();

        $rawEstudanteId = old('estudante_id', $this->planoTrabalho?->estudante_id ?? $this->estudanteId);
        $this->estudanteId = $this->getScalarEstudanteId($rawEstudanteId);

        $this->templateId = $this->escalar(old('template_formulario_id', $this->planoTrabalho?->template_formulario_id));

        if (filled($this->estudanteId)) {
            $this->estudante = Estudante::with('planosFlexibilizacaoCurricular')->find($this->estudanteId);
        }

        $rawDisciplinas = old(
            'disciplinas',
            $this->planoTrabalho ? [$this->planoTrabalho->disciplina_id] : $this->selectedDisciplinas
        );
        $this->selectedDisciplinas = array_map('strval', (array) $rawDisciplinas);

        if (filled($this->selectedDisciplinas)) {
            $this->updatedSelectedDisciplinas($this->selectedDisciplinas);
        }

        $rawProfessores = old(
            'professores',
            $this->planoTrabalho ? [$this->planoTrabalho->user_professor_id] : $this->selectedProfessores
        );
        $this->selectedProfessores = array_map('strval', (array) $rawProfessores);
    }

    public function updatedEstudanteId($value): void
    {
        $scalarId = $this->getScalarEstudanteId($value);
        $this->estudanteId = $scalarId;

        if (!filled($scalarId)) {
            $this->estudante = null;
            return;
        }

        $this->estudante = Estudante::with('planosFlexibilizacaoCurricular')->find($scalarId);

        if (!$this->estudante) {
            return;
        }

        $plano = $this->estudante->planosFlexibilizacaoCurricular?->last();
        if ($plano && !empty($plano->campos['componentesCurriculares'])) {
            $this->selectedDisciplinas = array_map('strval', (array) $plano->campos['componentesCurriculares']);
            $this->updatedSelectedDisciplinas($this->selectedDisciplinas);
        }
    }

    public function updatedSelectedDisciplinas($discs): void
    {
        $discs = (array) $discs;

        if (empty($discs)) {
            $this->displayProfessores = [];
            $this->selectedProfessores = [];
            return;
        }

        $disciplinas = Disciplina::with(['users:id,nome'])
            ->whereIn('id', $discs)
            ->get(['id', 'nome']);

        $professores = [];

        foreach ($disciplinas as $disciplina) {
            foreach ($disciplina->users as $professor) {
                $professores[(string) $professor->id]['nome'] = $professor->nome;
                $professores[(string) $professor->id]['disciplinas'][] = $disciplina->nome;
            }
        }

        $this->displayProfessores = [];

        foreach ($professores as $professorId => $professor) {
            $this->displayProfessores[$professorId] =
                $professor['nome'] .
                ' (' .
                implode(', ', $professor['disciplinas']) .
                ')';
        }

        $this->selectedProfessores = array_values(
            array_filter(
                $this->selectedProfessores,
                fn($professorId) => array_key_exists((string) $professorId, $this->displayProfessores)
            )
        );
    }

    #[On('disciplina-created')]
    public function onDisciplinaCreated(int|string $id, ?string $nome = null): void
    {
        $disciplina = Disciplina::with('curso')->find($id);

        if ($disciplina) {
            $stringId = (string) $id;
            $label = $disciplina->nome . ($disciplina->curso ? " - {$disciplina->curso->nome}" : '');
            $this->displayDisciplinas[$stringId] = $label;

            if (!in_array($stringId, $this->selectedDisciplinas, true)) {
                $this->selectedDisciplinas[] = $stringId;
            }

            $this->updatedSelectedDisciplinas($this->selectedDisciplinas);
        }
    }

    public function selecionarDisciplinasDoCurso(): void
    {
        $id = $this->getScalarEstudanteId();
        if (!filled($id)) {
            return;
        }

        $estudante = $this->estudante ?? Estudante::find($id);
        if (!$estudante) {
            return;
        }

        $this->selectedDisciplinas = Disciplina::where('curso_id', $estudante->curso_id)
            ->where('curso_periodo', $estudante->periodo)
            ->pluck('id')
            ->map(fn($discId) => (string) $discId)
            ->toArray();

        $this->updatedSelectedDisciplinas($this->selectedDisciplinas);
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

    private function escalar(mixed $valor): ?string
    {
        if (is_array($valor)) {
            $valor = reset($valor) ?: null;
        }

        return filled($valor) ? (string) $valor : null;
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
        return Estudante::orderBy('nome')
            ->get()
            ->mapWithKeys(fn($estudante) => [(string) $estudante->id => $estudante->nome])
            ->toArray();
    }

    #[Computed]
    public function templateOptions(): array
    {
        return TemplateFormulario::opcoesDe(TipoFormularioEnum::PLANO_TRABALHO);
    }
};
?>

@props(['planoTrabalho' => null])

@php
    $idEstudante = is_array($estudanteId) ? (reset($estudanteId) ?: null) : $estudanteId;
    $idTemplate = is_array($templateId) ? (reset($templateId) ?: null) : $templateId;
@endphp

<form
    action="{{ !$planoTrabalho ? route('planos-trabalho.store') : route('planos-trabalho.update', ['planoTrabalho' => $planoTrabalho]) }}"
    method="POST">
    @if ($planoTrabalho)
        @method('PATCH')
    @endif
    @csrf

    <div wire:ignore>
        <div class="flex gap-5 mb-5">
            <h2 class="text-display-small">Período de realização:</h2>
            <x-form.input type="date" size="small" name="periodo_inicio" appearance="outlined"
                :value="old('periodo_inicio', $planoTrabalho?->periodo_inicio?->format('Y-m-d'))" />
            <h2 class="text-display-small">a</h2>
            <x-form.input type="date" size="small" name="periodo_fim" appearance="outlined"
                :value="old('periodo_fim', $planoTrabalho?->periodo_fim?->format('Y-m-d'))" />
        </div>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>

        <div wire:key="selects-wrapper">
            <livewire:form.select type="select" label="Estudante" name="estudante_id" appearance="outlined"
                placeholder="Selecionar" :options="$this->estudanteOptions" wire:model.live="estudanteId"
                :disabled="filled($this->planoTrabalho)" wire:key="estudante-select-{{ $planoTrabalho?->id ?? 'new' }}" />

            <livewire:form.select label="Template do formulário" name="template_formulario_id" appearance="outlined"
                placeholder="Template padrão" wire:key="template-select-{{ $planoTrabalho?->id ?? 'new' }}"
                wire:model.live="templateId" :options="$this->templateOptions" />

            <div class="flex items-center gap-5">
                <livewire:form.select type="multiselect" label="Componentes curriculares" name="disciplinas"
                    appearance="outlined" placeholder="Selecionar" :options="$displayDisciplinas"
                    :disabled="filled($this->planoTrabalho)" wire:key="disciplinas-select" size="xlarge"
                    wire:model.live="selectedDisciplinas" />

                @if(!$planoTrabalho)
                    <livewire:modal.stateful.add-disciplina wire:key="add-disciplina-modal" />

                    <x-button type="button" size="dynamic" label="Selecionar todos do curso do estudante" color="secondary"
                        wire:click="selecionarDisciplinasDoCurso" />
                @endif
            </div>

            <livewire:form.select type="multiselect" label="Docentes" name="professores" appearance="outlined"
                size="xxlarge" :placeholder="filled($selectedDisciplinas) ? 'Selecionar' : 'Escolha um ou mais componentes curriculares'"
                :disabled="filled($this->planoTrabalho) || !filled($selectedDisciplinas)"
                no-result-message="Nenhum docente relacionado aos componentes selecionados foi encontrado"
                wire:key="professores-select-{{ $this->estudante?->id ?? 'none' }}" wire:model.live="selectedProfessores"
                :options="$displayProfessores" />

            @if ($this->planoTrabalho)
                <p class="text-label-medium my-5">Os campos acima não podem ser editados</p>
            @endif
        </div>

        <livewire:stateful-forms.campos-adicionais :tipo="App\Enums\TipoFormularioEnum::PLANO_TRABALHO->value"
            :template-id="$templateId" :registro="$planoTrabalho" secao="dadosEstudante" etapa="criacao"
            wire:key="campos-dados-estudante-{{ $idTemplate ?? 'padrao' }}" />
    </div>

    <livewire:stateful-forms.campos-adicionais :tipo="App\Enums\TipoFormularioEnum::PLANO_TRABALHO->value"
        :template-id="$templateId" :registro="$planoTrabalho" etapa="criacao"
        wire:key="campos-criacao-{{ $idTemplate ?? 'padrao' }}" />

    <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
        <h2 class="text-display-small">3. Conteúdos do componente curricular que necessitam de adaptação e/ou flexibilização:</h2>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5 border border-on-surface">
            @if (!$planoTrabalho)
                <p class="text-label-large">
                    Preenchimento automático com base nas ementas dos componentes curriculares selecionados
                </p>
            @else
                <p>{{ $planoTrabalho->disciplina?->ementa }}</p>
            @endif
        </div>
    </div>

    <livewire:stateful-forms.campos-adicionais :tipo="App\Enums\TipoFormularioEnum::PLANO_TRABALHO->value"
        :template-id="$templateId" :registro="$planoTrabalho" etapa="livre" wire:key="campos-livres-{{ $idTemplate ?? 'padrao' }}" />

    <livewire:stateful-forms.campos-adicionais :tipo="App\Enums\TipoFormularioEnum::PLANO_TRABALHO->value"
        :template-id="$templateId" :registro="$planoTrabalho" etapa="preenchimento" :apenas-definicoes="true"
        wire:key="campos-definicoes-docente-{{ $idTemplate ?? 'padrao' }}" />

    <input type="hidden" name="status" value="PENDENTE">

    <div class="flex justify-end gap-2">
        <x-button.cancel fallback="planos-trabalho.index" />

        @if(!$planoTrabalho)
            <x-button label="Pré-visualização" color="tertiary" type="submit"
                formaction="{{ route('planos-trabalho.preview') }}" formmethod="POST" formtarget="_blank" />
        @endif

        <x-button :label="$planoTrabalho ? 'Confirmar edições' : 'Enviar para docentes'" type="submit" />
    </div>
</form>
