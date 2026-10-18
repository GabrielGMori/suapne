<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Enums\TipoFormularioEnum;
use App\Livewire\Concerns\GerenciaCamposAdicionais;
use App\Models\Estudante;
use App\Models\Disciplina;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\TemplateFormulario;

new class extends Component {
    use GerenciaCamposAdicionais;

    public ?PlanoFlexibilizacaoCurricular $planoFlexibilizacao = null;

    public array|string|int|null $estudanteId = null;
    public array|string|int|null $templateId = null;
    public array $displayDisciplinas = [];
    public array $selectedDisciplinas = [];

    public function mount(?PlanoFlexibilizacaoCurricular $planoFlexibilizacao = null, mixed $estudanteId = null): void
    {
        $this->planoFlexibilizacao = $planoFlexibilizacao;

        $rawEstudanteId = old('estudante_id', $this->planoFlexibilizacao?->estudante_id ?? $estudanteId);
        $this->estudanteId = $this->getScalarEstudanteId($rawEstudanteId);

        $this->templateId = $this->escalar(old('template_formulario_id', $this->planoFlexibilizacao?->template_formulario_id));

        $this->selectedDisciplinas = old('campos.componentesCurriculares', $this->planoFlexibilizacao?->campos['componentesCurriculares'] ?? []);

        $this->loadDisciplinas();
    }

    public function updatedEstudanteId($value): void
    {
        $this->estudanteId = $this->getScalarEstudanteId($value);
        unset($this->camposDoFormulario);
        // Do NOT clear $this->selectedDisciplinas here so selections persist
    }

    public function updatedTemplateId(): void
    {
        unset($this->camposDoFormulario);
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
        return $this->escalar($value ?? $this->estudanteId);
    }

    private function escalar(mixed $valor): ?string
    {
        if (is_array($valor)) {
            $valor = reset($valor) ?: null;
        }

        return filled($valor) ? (string) $valor : null;
    }

    protected function contextoCampos(): array
    {
        $id = $this->escalar($this->templateId);

        return [TipoFormularioEnum::PLANO_FLEXIBILIZACAO, $id ? (int) $id : null, $this->planoFlexibilizacao];
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

    #[Computed]
    public function templateOptions(): array
    {
        return TemplateFormulario::opcoesDe(TipoFormularioEnum::PLANO_FLEXIBILIZACAO);
    }
};
?>

@props(['planoFlexibilizacao' => null])

@php
    $idTemplate = is_array($templateId) ? (reset($templateId) ?: null) : $templateId;
    $tipo = App\Enums\TipoFormularioEnum::PLANO_FLEXIBILIZACAO->value;
    $componentesCampo = $this->campoDoFormulario('componentesCurriculares');
@endphp

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

            <livewire:form.select label="Template do formulário" name="template_formulario_id" appearance="outlined"
                size="large" placeholder="Template padrão"
                wire:key="template-select-{{ $planoFlexibilizacao?->id ?? 'new' }}" wire:model.live="templateId"
                :options="$this->templateOptions" />
        </div>

        <livewire:stateful-forms.campos-adicionais :tipo="$tipo" :template-id="$templateId" :registro="$planoFlexibilizacao"
            ate="componentesCurriculares" wire:key="campos-antes-{{ $idTemplate ?? 'padrao' }}" />

        @if ($componentesCampo)
            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:key="componentes-curriculares">
                <h2 class="text-display-small">{{ App\Support\CamposTemplate::titulo($this->numeroDoCampo('componentesCurriculares'), $componentesCampo['rotulo']) }}</h2>

                <div class="flex items-center gap-5">
                    <livewire:form.select type="multiselect" label="Componentes curriculares" placeholder="Selecionar"
                        appearance="outlined" name="campos[componentesCurriculares]" size="xlarge"
                        wire:key="disciplinas-select" wire:model.live="selectedDisciplinas" :options="$displayDisciplinas" />

                    <livewire:modal.stateful.add-disciplina wire:key="add-disciplina-modal" />

                    <x-button type="button" size="dynamic" label="Selecionar todos do curso do estudante selecionado"
                        color="secondary" wire:click="selecionarDisciplinasDoCurso" />
                </div>
            </div>
            <x-campo-extra-hidden :campo="$componentesCampo" />
        @endif

        <livewire:stateful-forms.campos-adicionais :tipo="$tipo" :template-id="$templateId" :registro="$planoFlexibilizacao"
            depois="componentesCurriculares" wire:key="campos-depois-{{ $idTemplate ?? 'padrao' }}" />

        <div class="flex justify-end gap-2">
            <x-button.cancel fallback="planos-flexibilizacao.index" />
            <x-button type="submit" :label="$planoFlexibilizacao ? 'Salvar Alterações' : 'Registrar'" />
        </div>
    </div>
</form>
