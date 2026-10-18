<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Enums\TipoFormularioEnum;
use App\Livewire\Concerns\GerenciaCamposAdicionais;
use App\Models\Estudante;
use App\Models\AtendimentoSemanal;
use App\Models\TemplateFormulario;

new class extends Component {
    use GerenciaCamposAdicionais;

    public ?AtendimentoSemanal $atendimento = null;

    public array|string|int|null $estudanteId = null;
    public array|string|int|null $templateId = null;
    public ?string $perfil = '';

    public function mount(?AtendimentoSemanal $atendimento = null, mixed $estudanteId = null): void
    {
        $this->atendimento = $atendimento;

        $rawEstudanteId = old('estudante_id', $this->atendimento?->estudante_id ?? $estudanteId);
        $this->estudanteId = $this->getScalarEstudanteId($rawEstudanteId);

        $this->templateId = $this->escalar(old('template_formulario_id', $this->atendimento?->template_formulario_id));

        $oldPerfil = old('campos.perfilDoEstudante');

        if ($oldPerfil !== null) {
            $this->perfil = $oldPerfil;
        } elseif ($this->atendimento?->campos['perfilDoEstudante'] ?? null) {
            $this->perfil = $this->atendimento->campos['perfilDoEstudante'];
        } elseif (filled($this->estudanteId)) {
            $this->loadPerfilForEstudante($this->estudanteId);
        }
    }

    public function updatedEstudanteId($value): void
    {
        $id = $this->getScalarEstudanteId($value);
        $this->loadPerfilForEstudante($id);
        unset($this->camposDoFormulario);
    }

    public function updatedTemplateId(): void
    {
        unset($this->camposDoFormulario);
    }

    private function loadPerfilForEstudante(?string $id): void
    {
        if (!filled($id)) {
            $this->perfil = '';
            return;
        }

        $estudante = Estudante::find($id);

        if (!$estudante) {
            $this->perfil = '';
            return;
        }

        $ultimoAtendimento = $estudante->atendimentosSemanais()->orderBy('data', 'DESC')->first();

        $this->perfil = $ultimoAtendimento?->campos['perfilDoEstudante'] ?? '';
    }

    private function getScalarEstudanteId(mixed $value = null): ?string
    {
        $val = $value ?? $this->estudanteId;

        return $this->escalar($val);
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

        return [TipoFormularioEnum::ATENDIMENTO_SEMANAL, $id ? (int) $id : null, $this->atendimento];
    }

    #[Computed]
    public function estudanteOptions(): array
    {
        return Estudante::orderBy('nome')->pluck('nome', 'id')->toArray();
    }

    #[Computed]
    public function templateOptions(): array
    {
        return TemplateFormulario::opcoesDe(TipoFormularioEnum::ATENDIMENTO_SEMANAL);
    }
};
?>

@props(['atendimento' => null])

@php
    $idTemplate = is_array($templateId) ? (reset($templateId) ?: null) : $templateId;
    $perfilCampo = $this->campoDoFormulario('perfilDoEstudante');
@endphp

<form action="{{ $atendimento ? route('atendimentos.update', $atendimento) : route('atendimentos.store') }}"
    method="POST">
    @csrf
    @if ($atendimento)
        @method('PATCH')
    @endif

    <div class="flex flex-col min-h bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>

        <livewire:form.select label="Estudante" name="estudante_id" appearance="outlined" placeholder="Selecionar"
            wire:key="estudante-select-{{ $atendimento?->id ?? 'new' }}" wire:model.live="estudanteId"
            :options="$this->estudanteOptions" />

        <livewire:form.select label="Template do formulário" name="template_formulario_id" appearance="outlined"
            placeholder="Template padrão" wire:key="template-select-{{ $atendimento?->id ?? 'new' }}"
            wire:model.live="templateId" :options="$this->templateOptions" />

        <x-form.input label="Local" appearance="outlined" size="small" name="local" wire:ignore
            :value="old('local', $atendimento?->local ?? '')" />

        <x-form.input type="datetime" label="Dia" appearance="outlined" name="data" wire:ignore
            :value="old('data', $atendimento?->data ?? '')" />

        @if ($perfilCampo)
            <div class="flex flex-col" wire:key="perfil-wrapper">
                <label for="campos[perfilDoEstudante]" class="form-label form-label-outlined">Perfil do Estudante</label>

                <x-form.input type="textarea" appearance="outlined" name="campos[perfilDoEstudante]"
                    wire:key="perfil-textarea" size="full" wire:model.blur="perfil" />
            </div>
            <x-campo-extra-hidden :campo="$perfilCampo" />
        @endif
    </div>

    <livewire:stateful-forms.campos-adicionais :tipo="App\Enums\TipoFormularioEnum::ATENDIMENTO_SEMANAL->value"
        :template-id="$templateId" :registro="$atendimento" wire:key="campos-adicionais-{{ $idTemplate ?? 'padrao' }}" />

    <div class="flex justify-end gap-2">
        <x-button.cancel fallback="atendimentos.index" />
        <x-button type="submit" label="{{ $atendimento ? 'Salvar Alterações' : 'Registrar' }}" />
    </div>
</form>
