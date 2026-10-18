<?php

use App\Enums\TipoFormularioEnum;
use App\Models\TemplateFormulario;
use App\Support\CamposTemplate;
use Livewire\Component;

new class extends Component {
    public ?TemplateFormulario $template = null;
    public string $tipo;

    public string $nome = '';
    public array $campos = [];

    public bool $adicionando = false;
    public string $novoRotulo = '';
    public array|string|null $novoTipo = ['textarea'];
    public bool $novoObrigatorio = false;
    public string $novasOpcoes = '';

    public function mount(?TemplateFormulario $template = null, string $tipo = ''): void
    {
        $this->template = $template?->exists ? $template : null;
        $this->tipo = $tipo ?: ($template?->tipo?->value ?? TipoFormularioEnum::ATENDIMENTO_SEMANAL->value);

        $this->nome = (string) old('nome', $this->template?->nome);
        $this->campos = CamposTemplate::ordenar((array) old('campos', $this->template?->campos ?? CamposTemplate::campos($this->tipoEnum())));
    }

    public function adicionar(): void
    {
        $this->novoTipo = is_array($this->novoTipo) ? (string) (reset($this->novoTipo) ?: '') : (string) $this->novoTipo;

        $this->validate([
            'novoRotulo' => ['required', 'string', 'max:300'],
            'novoTipo' => ['required', 'in:' . implode(',', array_keys(CamposTemplate::TIPOS_CAMPO))],
            'novasOpcoes' => ['required_if:novoTipo,select', 'string', 'max:500'],
        ], [], ['novoRotulo' => 'nome do campo', 'novoTipo' => 'tipo', 'novasOpcoes' => 'opções']);

        $opcoes = array_values(array_unique(array_filter(array_map('trim', explode(',', $this->novasOpcoes)))));

        if ($this->novoTipo === 'select' && count($opcoes) < 2) {
            $this->addError('novasOpcoes', 'Informe pelo menos duas opções, separadas por vírgula.');
            return;
        }

        $this->campos[] = CamposTemplate::novoCampo($this->novoRotulo, $this->novoTipo, $this->novoObrigatorio, $this->campos, $opcoes);

        $this->reset('adicionando', 'novoRotulo', 'novoTipo', 'novoObrigatorio', 'novasOpcoes');
        $this->novoTipo = ['textarea'];
    }

    public function remover(int $indice): void
    {
        if (($this->campos[$indice]['fixo'] ?? false)) {
            return;
        }

        unset($this->campos[$indice]);
        $this->campos = array_values($this->campos);
    }

    public function reordenar(array $ordem): void
    {
        $novos = [];

        foreach (array_unique(array_map('intval', $ordem)) as $indice) {
            if (isset($this->campos[$indice])) {
                $novos[] = $this->campos[$indice];
            }
        }

        if (count($novos) === count($this->campos)) {
            $this->campos = CamposTemplate::ordenar($novos);
        }
    }

    public function itens(): array
    {
        $itens = [];

        foreach ($this->campos as $indice => $campo) {
            $grupo = $campo['grupo'] ?? null;
            $ultimo = array_key_last($itens);

            if ($grupo !== null && $ultimo !== null && $itens[$ultimo]['grupo'] === $grupo) {
                $itens[$ultimo]['indices'][] = $indice;
                continue;
            }

            $itens[] = [
                'grupo' => $grupo,
                'titulo' => $campo['grupoTitulo'] ?? null,
                'indices' => [$indice],
                'noTopo' => filled($campo['secao'] ?? null),
            ];
        }

        return $itens;
    }

    public function cancelarNovo(): void
    {
        $this->reset('adicionando', 'novoRotulo', 'novoObrigatorio', 'novasOpcoes');
        $this->novoTipo = ['textarea'];
        $this->resetValidation();
    }

    public function tipoEnum(): TipoFormularioEnum
    {
        return TipoFormularioEnum::from($this->tipo);
    }

};
?>

@props(['template' => null, 'tipo' => ''])

@php
    $acao = $template?->exists
        ? route('templates.update', ['templateFormulario' => $template])
        : route('templates.store', ['tipo' => $this->tipoEnum()]);
@endphp

<form action="{{ $acao }}" method="POST">
    @csrf
    @if ($template?->exists)
        @method('PATCH')
    @endif

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Dados do template</h2>
        <hr class="text-on-surface">

        <x-form.input label="Nome do template" name="nome" appearance="outlined" size="large"
            wire:model="nome" :value="$nome" :error="$errors->first('nome')" />
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <h2 class="text-display-small">Campos do formulário</h2>
            <p class="text-body-small text-secondary-accent">
                Arraste os campos para mudar a ordem
            </p>
        </div>
        <hr class="text-on-surface">

        @error('campos')
            <p class="text-body-medium text-error">{{ $message }}</p>
        @enderror

        @php $numeros = CamposTemplate::numeracao($this->tipoEnum(), $campos); @endphp

        <div wire:key="lista-campos"
            x-data="{
                origem: null,
                sobre: null,
                ordem() { return [...$el.querySelectorAll('[data-item]')].map(e => e.dataset.item) },
                soltar() {
                    if (this.origem === null || this.sobre === null || this.origem === this.sobre) { this.limpar(); return }
                    const atual = this.ordem()
                    const [movido] = atual.splice(atual.indexOf(this.origem), 1)
                    atual.splice(atual.indexOf(this.sobre), 0, movido)
                    $wire.reordenar(atual.flatMap(item => $el.querySelector(`[data-item='${item}']`).dataset.indices.split(',')))
                    this.limpar()
                },
                limpar() { this.origem = null; this.sobre = null },
            }"
            x-on:dragend="limpar()"
            class="flex flex-col gap-3">

            @foreach ($this->itens() as $posicao => $item)
                @php $primeiro = $campos[$item['indices'][0]]; @endphp

                @if ($item['noTopo'])
                    <div wire:key="item-{{ $primeiro['chave'] }}" data-item="{{ $posicao }}"
                        data-indices="{{ implode(',', $item['indices']) }}" x-data="{ arrastavel: false }"
                        class="rounded-lg bg-on-surface p-4">
                        @include('components.stateful-forms.partials.campo-template', [
                            'campo' => $primeiro,
                            'indice' => $item['indices'][0],
                            'numero' => null,
                        ])
                    </div>
                @else
                    <div wire:key="item-{{ $primeiro['chave'] }}" data-item="{{ $posicao }}"
                        data-indices="{{ implode(',', $item['indices']) }}"
                        x-data="{ arrastavel: true }"
                        x-bind:draggable="arrastavel"
                        x-on:dragstart="origem = '{{ $posicao }}'; $event.dataTransfer.effectAllowed = 'move'"
                        x-on:dragover.prevent="sobre = '{{ $posicao }}'"
                        x-on:drop.prevent="soltar()"
                        x-bind:class="{
                            'opacity-40': origem === '{{ $posicao }}',
                            'ring-2 ring-primary-accent': sobre === '{{ $posicao }}' && origem !== '{{ $posicao }}',
                        }"
                        class="rounded-lg bg-on-surface p-4 transition-colors hover:bg-on-surface/70 cursor-grab active:cursor-grabbing">

                        @if ($item['grupo'] !== null)
                            <div class="flex flex-col gap-3">
                                <p class="text-title-small">{{ CamposTemplate::titulo($numeros[$primeiro['chave']] ?? null, $item['titulo']) }}</p>

                                @foreach ($item['indices'] as $indice)
                                    <div wire:key="campo-{{ $campos[$indice]['chave'] }}" class="rounded-lg bg-surface p-4">
                                        @include('components.stateful-forms.partials.campo-template', [
                                            'campo' => $campos[$indice],
                                            'indice' => $indice,
                                            'numero' => null,
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        @else
                            @include('components.stateful-forms.partials.campo-template', [
                                'campo' => $primeiro,
                                'indice' => $item['indices'][0],
                                'numero' => $numeros[$primeiro['chave']] ?? null,
                            ])
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <div @class(['flex flex-col gap-5 rounded-lg', 'bg-on-surface p-4' => $adicionando]) wire:key="novo-campo">
            @if (!$adicionando)
                <div class="flex justify-center">
                    <x-button type="button" icon="add" label="Adicionar campo" color="secondary" size="dynamic"
                        wire:click="$set('adicionando', true)" />
                </div>
            @else
                <h3 class="text-title-small">Novo campo</h3>

                <div class="flex flex-wrap items-end gap-5">
                    <x-form.input label="Nome do campo" name="novo_rotulo" appearance="outlined" size="large"
                        wire:model="novoRotulo" wire:keydown.enter.prevent="adicionar" :error="$errors->first('novoRotulo')" />

                    <livewire:form.select label="Tipo" name="novo_tipo" appearance="outlined" placeholder="Selecionar"
                        wire:model.live="novoTipo" :options="CamposTemplate::TIPOS_CAMPO" wire:key="novo-tipo" />

                    @if (in_array('select', (array) $novoTipo, true))
                        <x-form.input label="Opções (separadas por vírgula)" name="novas_opcoes" appearance="outlined" size="large"
                            placeholder="Ex.: Sim, Não" wire:model="novasOpcoes" wire:keydown.enter.prevent="adicionar"
                            :error="$errors->first('novasOpcoes')" />
                    @endif

                    <label class="flex items-center gap-2 mb-3 cursor-pointer">
                        <input type="checkbox" class="h-5 w-5 accent-primary" wire:model="novoObrigatorio">
                        <span class="text-body-medium">Preenchimento obrigatório</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2">
                    <x-button type="button" label="Cancelar" color="secondary" wire:click="cancelarNovo" />
                    <x-button type="button" label="Adicionar" color="primary" wire:click="adicionar" />
                </div>
            @endif
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <x-button.cancel fallback="templates.tipo" :args="['tipo' => $this->tipoEnum()]" />
        <x-button type="submit" :label="$template?->exists ? 'Salvar alterações' : 'Criar template'" />
    </div>
</form>
