<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Enums\TipoFormularioEnum;
use App\Livewire\Concerns\GerenciaCamposAdicionais;
use App\Models\Estudante;
use App\Models\AtendimentoSemanal;

new class extends Component {
    use GerenciaCamposAdicionais;

    public ?AtendimentoSemanal $atendimento = null;

    public array|string|int|null $estudanteId = null;
    public ?string $perfil = '';

    public function mount(?AtendimentoSemanal $atendimento = null, mixed $estudanteId = null): void
    {
        $this->atendimento = $atendimento;

        // Priority order: old input > model attribute > passed prop
        $rawEstudanteId = old('estudante_id', $this->atendimento?->estudante_id ?? $estudanteId);
        $this->estudanteId = $this->getScalarEstudanteId($rawEstudanteId);

        // Priority order: old input > current record > latest student profile
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

        if (is_array($val)) {
            $val = reset($val) ?: null;
        }

        return filled($val) ? (string) $val : null;
    }

    protected function contextoCampos(): array
    {
        $id = $this->getScalarEstudanteId();

        return [TipoFormularioEnum::ATENDIMENTO_SEMANAL, $id ? (int) $id : null, $this->atendimento];
    }

    #[Computed]
    public function estudanteOptions(): array
    {
        return Estudante::orderBy('nome')->pluck('nome', 'id')->toArray();
    }
};
?>

@props(['atendimento' => null])

@php
    $idEstudante = is_array($estudanteId) ? (reset($estudanteId) ?: null) : $estudanteId;
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

        <x-form.input label="Local" appearance="outlined" size="small" name="local" wire:ignore
            :value="old('local', $atendimento?->local ?? '')" />

        <x-form.input type="datetime" label="Dia" appearance="outlined" name="data" wire:ignore
            :value="old('data', $atendimento?->data ?? '')" />

        @if ($perfilCampo)
            <div class="flex flex-col" wire:key="perfil-wrapper">
                <div class="flex justify-between items-center">
                    <label for="campos[perfilDoEstudante]" class="form-label form-label-outlined">Perfil do Estudante</label>

                    @if ($this->podeEditarCampos())
                        <x-botao-remover-campo acao="removerCampo('perfilDoEstudante')" rotulo="Perfil do Estudante" registro="Atendimentos" />
                    @endif
                </div>

                <x-form.input type="textarea" appearance="outlined" name="campos[perfilDoEstudante]"
                    wire:key="perfil-textarea" size="full" wire:model.blur="perfil" />
            </div>
            <x-campo-extra-hidden :campo="$perfilCampo" />
        @endif
    </div>

    <livewire:stateful-forms.campos-adicionais :tipo="App\Enums\TipoFormularioEnum::ATENDIMENTO_SEMANAL->value"
        :estudante-id="$estudanteId" :registro="$atendimento" wire:key="campos-adicionais-{{ $idEstudante ?? 'sem' }}" />

    <div class="flex justify-end gap-2">
        <x-button.cancel fallback="atendimentos.index" />
        <x-button type="submit" label="{{ $atendimento ? 'Salvar Alterações' : 'Registrar' }}" />
    </div>
</form>
