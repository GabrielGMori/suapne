<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Estudante;
use App\Models\AtendimentoSemanal;

new class extends Component {
    public ?AtendimentoSemanal $atendimento = null;

    public ?string $estudanteId = null;
    public ?string $perfil = '';

    public function mount(?AtendimentoSemanal $atendimento = null, mixed $estudanteId = null): void
    {
        $this->atendimento = $atendimento;

        // Priority order: old input > model attribute > passed prop
        $initialEstudanteId = old('estudante_id', $this->atendimento?->estudante_id ?? $estudanteId);
        $this->estudanteId = filled($initialEstudanteId) ? (string) $initialEstudanteId : null;

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

    public function updatedEstudanteId(?string $value): void
    {
        $this->loadPerfilForEstudante($value);
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

    #[Computed]
    public function estudanteOptions(): array
    {
        return Estudante::orderBy('nome')->pluck('nome', 'id')->toArray();
    }
};
?>

@props(['atendimento' => null])

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

        <x-form.input type="textarea" label="Perfil do Estudante" appearance="outlined" name="campos[perfilDoEstudante]"
            wire:key="perfil-textarea" size="full" wire:model.blur="perfil" />
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Registro do Atendimento</h2>
        <x-form.input type="textarea" name="campos[registroDoAtendimento]" appearance="outlined" size="full"
            wire:ignore :value="old('campos.registroDoAtendimento', $atendimento?->campos['registroDoAtendimento'] ?? '')" />
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Encaminhamentos</h2>
        <x-form.input type="textarea" name="campos[encaminhamentos]" appearance="outlined" size="full" wire:ignore
            :value="old('campos.encaminhamentos', $atendimento?->campos['encaminhamentos'] ?? '')" />
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Observações adicionais</h2>
        <x-form.input type="textarea" name="campos[observacoesAdicionais]" appearance="outlined" size="full"
            wire:ignore :value="old('campos.observacoesAdicionais', $atendimento?->campos['observacoesAdicionais'] ?? '')" />
    </div>

    <div class="flex justify-end gap-2">
        <x-button.cancel fallback="atendimentos.index" />
        <x-button type="submit" label="{{ $atendimento ? 'Salvar Alterações' : 'Registrar' }}" />
    </div>
</form>
