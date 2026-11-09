<?php

use Livewire\Component;
use App\Enums\TipoFormularioEnum;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use App\Models\TemplateFormulario;

new class extends Component {
    public ?EntrevistaFamiliar $entrevistaFamiliar = null;
    public ?Estudante $estudante = null;

    public ?int $templateId = null;

    public function mount(?EntrevistaFamiliar $entrevistaFamiliar = null, ?Estudante $estudante = null): void
    {
        $this->entrevistaFamiliar = $entrevistaFamiliar?->exists ? $entrevistaFamiliar : null;
        $this->estudante = $estudante;

        $this->templateId = $this->entrevistaFamiliar
            ? $this->entrevistaFamiliar->template_formulario_id
            : TemplateFormulario::ativoDe(TipoFormularioEnum::ENTREVISTA_FAMILIAR)->id;
    }

    public function valoresIniciais(): array
    {
        return [
            'nomeCompleto' => $this->estudante?->nome,
            'idade' => $this->estudante?->idade,
            'nomeMae' => $this->estudante?->nome_mae,
            'nomePai' => $this->estudante?->nome_pai,
            'nomeResponsavel' => $this->estudante?->nome_responsavel,
            'celularEstudante' => $this->estudante?->telefone,
            'celularMae' => $this->estudante?->telefone_mae,
            'celularPai' => $this->estudante?->telefone_pai,
            'celularFixo' => $this->estudante?->telefone,
            'emailEstudante' => $this->estudante?->email_pessoal,
            'emailResponsavel' => $this->estudante?->email_responsavel,
            'nomeCurso' => $this->estudante?->curso?->nome,
            'matricula' => $this->estudante?->matricula,
            'anoPeriodo' => $this->estudante?->periodo,
        ];
    }
};
?>

@props(['entrevistaFamiliar' => null, 'estudante' => null])

@php
    $tipo = App\Enums\TipoFormularioEnum::ENTREVISTA_FAMILIAR->value;
    $valoresIniciais = $this->valoresIniciais();
@endphp

<form action="{{ $entrevistaFamiliar == null ? route('estudantes.entrevistas-familiares.store', ['estudante' => $estudante?->id]) : route('estudantes.entrevistas-familiares.update', ['estudante' => $estudante?->id, 'entrevistaFamiliar' => $entrevistaFamiliar]) }}"
    method="POST">
    @if ($entrevistaFamiliar !== null)
        @method('PATCH')
    @endif
    @csrf
    <x-secao-expansivel title="1. Identificação do Estudante" class="mb-5">
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
            <x-form.input type="date" label="Data da entrevista" appearance="outlined" size="small" wire:ignore
                name="data" :value="old('data', $entrevistaFamiliar?->data?->format('Y-m-d'))" required />
            <x-form.input label="Responsável pelo preenchimento" appearance="outlined" size="large" wire:ignore
                name="responsavel_preenchimento" :value="old('responsavel_preenchimento', $entrevistaFamiliar?->responsavel_preenchimento ?? '')" required />

            <livewire:stateful-forms.campos-adicionais :tipo="$tipo" :template-id="$templateId" :registro="$entrevistaFamiliar"
                :valores="$valoresIniciais" secao="dadosEstudante" :secoes="true"
                wire:key="campos-identificacao" />
        </div>
    </x-secao-expansivel>

    <livewire:stateful-forms.campos-adicionais :tipo="$tipo" :template-id="$templateId" :registro="$entrevistaFamiliar"
        :valores="$valoresIniciais" :secoes="true" wire:key="campos-secoes" />

    <div class="flex justify-end gap-2">
        <x-button.cancel fallback="estudantes.show" :args="['estudante' => $estudante]" />
        <x-button type="submit" :label="$entrevistaFamiliar ? 'Salvar' : 'Registrar'" />
    </div>
</form>
