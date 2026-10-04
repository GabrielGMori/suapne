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

    public function mount(?TemplateFormulario $template = null, string $tipo = ''): void
    {
        $this->template = $template?->exists ? $template : null;
        $this->tipo = $tipo ?: ($template?->tipo?->value ?? TipoFormularioEnum::ATENDIMENTO_SEMANAL->value);

        $this->nome = old('nome', $this->template?->nome ?? '');
        $this->campos = old('campos', $this->template?->campos ?? CamposTemplate::campos($this->tipoEnum()));
    }

    public function adicionar(): void
    {
        $this->novoTipo = is_array($this->novoTipo) ? (string) (reset($this->novoTipo) ?: '') : (string) $this->novoTipo;

        $this->validate([
            'novoRotulo' => ['required', 'string', 'max:300'],
            'novoTipo' => ['required', 'in:' . implode(',', array_keys(CamposTemplate::TIPOS_CAMPO))],
        ], [], ['novoRotulo' => 'nome do campo', 'novoTipo' => 'tipo']);

        $this->campos[] = CamposTemplate::novoCampo($this->novoRotulo, $this->novoTipo, $this->novoObrigatorio, $this->campos);

        $this->reset('adicionando', 'novoRotulo', 'novoTipo', 'novoObrigatorio');
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

        foreach ($ordem as $indice) {
            if (isset($this->campos[(int) $indice])) {
                $novos[] = $this->campos[(int) $indice];
            }
        }

        if (count($novos) === count($this->campos)) {
            $this->campos = $novos;
        }
    }

    public function mover(int $de, int $para): void
    {
        if (!isset($this->campos[$de]) || !isset($this->campos[$para])) {
            return;
        }

        $campo = $this->campos[$de];
        unset($this->campos[$de]);
        $this->campos = array_values($this->campos);
        array_splice($this->campos, $para, 0, [$campo]);
    }

    public function cancelarNovo(): void
    {
        $this->reset('adicionando', 'novoRotulo', 'novoObrigatorio');
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

        <div wire:key="lista-campos"
            x-data="{
                origem: null,
                sobre: null,
                ordem() { return [...$el.querySelectorAll('[data-indice]')].map(e => e.dataset.indice) },
                soltar() {
                    if (this.origem === null || this.sobre === null || this.origem === this.sobre) { this.limpar(); return }
                    const atual = this.ordem()
                    const [movido] = atual.splice(atual.indexOf(this.origem), 1)
                    atual.splice(atual.indexOf(this.sobre), 0, movido)
                    $wire.reordenar(atual)
                    this.limpar()
                },
                limpar() { this.origem = null; this.sobre = null },
            }"
            x-on:dragend="limpar()"
            class="flex flex-col gap-3">

            @foreach ($campos as $indice => $campo)
                @php
                    $fixo = $campo['fixo'] ?? false;
                    $rotuloTipo = CamposTemplate::TIPOS_CAMPO[$campo['tipo']] ?? 'Campo do sistema';
                @endphp

                <div wire:key="campo-{{ $campo['chave'] }}" data-indice="{{ $indice }}"
                    x-data="{ aberto: false, arrastavel: true }"
                    x-bind:draggable="arrastavel"
                    x-on:dragstart="origem = '{{ $indice }}'; $event.dataTransfer.effectAllowed = 'move'"
                    x-on:dragover.prevent="sobre = '{{ $indice }}'"
                    x-on:drop.prevent="soltar()"
                    x-bind:class="{
                        'opacity-40': origem === '{{ $indice }}',
                        'ring-2 ring-primary-accent': sobre === '{{ $indice }}' && origem !== '{{ $indice }}',
                    }"
                    class="rounded-lg bg-on-surface p-4 transition-colors hover:bg-on-surface/70 cursor-grab active:cursor-grabbing">

                    <div class="flex flex-wrap items-center gap-4">
                        <div class="grow min-w-60">
                            <p class="text-body-large">{{ $campo['rotuloFormulario'] ?? $campo['rotulo'] }}</p>
                            @if (!empty($campo['descricao']))
                                <p class="text-body-small text-secondary-accent">{{ $campo['descricao'] }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-2" x-on:mouseenter="arrastavel = false" x-on:mouseleave="arrastavel = true">
                            <x-status :label="$rotuloTipo" color="dark" :filled="false" />

                            @if ($campo['obrigatorio'] ?? false)
                                <x-status label="Obrigatório" color="warning" :filled="false" />
                            @endif

                            <button type="button" x-on:click="aberto = !aberto"
                                x-bind:title="aberto ? 'Recolher pré-visualização' : 'Ver como aparece no formulário'"
                                class="flex items-center text-secondary-accent hover:text-primary transition-colors cursor-pointer">
                                <x-icon size="24" class="transition-transform duration-200"
                                    x-bind:class="aberto ? 'rotate-180' : ''">keyboard_arrow_down</x-icon>
                            </button>

                            @if ($fixo)
                                <span title="{{ $campo['motivoFixo'] ?? 'Campo que não pode ser removido.' }}"
                                    class="flex items-center text-secondary-accent">
                                    <x-icon size="22">lock</x-icon>
                                </span>
                            @else
                                <button type="button" title="Remover campo" wire:click="remover({{ $indice }})"
                                    class="flex items-center text-secondary-accent hover:text-red transition-colors cursor-pointer">
                                    <x-icon size="22">close</x-icon>
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="grid transition-[grid-template-rows] duration-300 ease-out"
                        x-bind:class="aberto ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                        <div class="min-h-0 overflow-hidden">
                            <div class="mt-4 cursor-default" x-on:mouseenter="arrastavel = false" x-on:mouseleave="arrastavel = true">
                                @include('components.stateful-forms.partials.previa-campo', ['campo' => $campo])
                            </div>
                        </div>
                    </div>

                    @foreach ($campo as $atributo => $valor)
                        @if (is_array($valor))
                            @foreach ($valor as $chaveOpcao => $valorOpcao)
                                <input type="hidden" name="campos[{{ $indice }}][{{ $atributo }}][{{ $chaveOpcao }}]" value="{{ $valorOpcao }}">
                            @endforeach
                        @else
                            <input type="hidden" name="campos[{{ $indice }}][{{ $atributo }}]" value="{{ is_bool($valor) ? (int) $valor : $valor }}">
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="flex flex-col gap-5 rounded-lg border-2 border-dashed border-on-surface p-5" wire:key="novo-campo">
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
                        wire:model="novoTipo" :options="CamposTemplate::TIPOS_CAMPO" wire:key="novo-tipo" />

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
