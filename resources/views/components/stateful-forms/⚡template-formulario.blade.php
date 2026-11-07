<?php

use App\Enums\TipoFormularioEnum;
use App\Models\TemplateFormulario;
use App\Support\CamposTemplate;
use Illuminate\Validation\Rule;
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
    public array|string|null $novaSecao = [CamposTemplate::SEM_SECAO];
    public string $novaSecaoTitulo = '';

    public function mount(?TemplateFormulario $template = null, string $tipo = ''): void
    {
        $this->template = $template?->exists ? $template : null;
        $this->tipo = $tipo ?: ($template?->tipo?->value ?? TipoFormularioEnum::ATENDIMENTO_SEMANAL->value);

        $this->nome = (string) old('nome', $this->template?->nome);
        $this->campos = CamposTemplate::ordenar(CamposTemplate::decodificar((array) old('campos', $this->template?->campos ?? CamposTemplate::campos($this->tipoEnum()))));
    }

    public function adicionar(): void
    {
        $this->novoTipo = is_array($this->novoTipo) ? (string) (reset($this->novoTipo) ?: '') : (string) $this->novoTipo;
        $this->novaSecao = is_array($this->novaSecao) ? (string) (reset($this->novaSecao) ?: CamposTemplate::SEM_SECAO) : (string) ($this->novaSecao ?: CamposTemplate::SEM_SECAO);

        $this->validate([
            'novoRotulo' => ['required', 'string', 'max:300'],
            'novoTipo' => ['required', 'in:' . implode(',', array_keys(CamposTemplate::TIPOS_CAMPO))],
            'novasOpcoes' => ['required_if:novoTipo,select', 'string', 'max:500'],
            'novaSecao' => ['required', Rule::in(array_keys($this->secoes()))],
            'novaSecaoTitulo' => ['required_if:novaSecao,' . CamposTemplate::NOVA_SECAO, 'string', 'max:150'],
        ], [], ['novoRotulo' => 'nome do campo', 'novoTipo' => 'tipo', 'novasOpcoes' => 'opções', 'novaSecao' => 'seção', 'novaSecaoTitulo' => 'nome da seção']);

        $opcoes = array_values(array_unique(array_filter(array_map('trim', explode(',', $this->novasOpcoes)))));

        if ($this->novoTipo === 'select' && count($opcoes) < 2) {
            $this->addError('novasOpcoes', 'Informe pelo menos duas opções, separadas por vírgula.');
            return;
        }

        $campo = CamposTemplate::novoCampo($this->novoRotulo, $this->novoTipo, $this->novoObrigatorio, $this->campos, $opcoes);
        $this->campos = CamposTemplate::inserir($this->campos, $campo, $this->novaSecao, $this->novaSecaoTitulo);

        $this->reset('adicionando', 'novoRotulo', 'novoTipo', 'novoObrigatorio', 'novasOpcoes', 'novaSecao', 'novaSecaoTitulo');
        $this->novoTipo = ['textarea'];
        $this->novaSecao = [CamposTemplate::SEM_SECAO];
    }

    public function secoes(): array
    {
        return CamposTemplate::secoesDisponiveis($this->tipoEnum(), $this->campos);
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
        $this->reset('adicionando', 'novoRotulo', 'novoObrigatorio', 'novasOpcoes', 'novaSecaoTitulo');
        $this->novoTipo = ['textarea'];
        $this->novaSecao = [CamposTemplate::SEM_SECAO];
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
                Arraste os campos ou as seções para mudar a ordem
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
                campo: null,
                sobreCampo: null,
                zona: null,
                ordem() { return [...$el.querySelectorAll('[data-item]')].map(e => e.dataset.item) },
                indices(itens) { return itens.flatMap(item => $el.querySelector(`[data-item='${item}']`).dataset.indices.split(',')) },
                mover(lista, de, para) {
                    const posicao = lista.indexOf(para)
                    lista.splice(lista.indexOf(de), 1)
                    lista.splice(posicao, 0, de)
                    return lista
                },
                iniciar(evento, item) {
                    this.origem = item
                    evento.dataTransfer.effectAllowed = 'move'
                    evento.dataTransfer.setData('text/plain', item)
                },
                passar(evento, item) {
                    if (this.origem === null) return
                    evento.preventDefault()
                    this.sobre = item
                },
                soltar(evento) {
                    if (this.origem === null) return
                    evento.preventDefault()
                    if (this.sobre !== null && this.origem !== this.sobre) {
                        $wire.reordenar(this.indices(this.mover(this.ordem(), this.origem, this.sobre)))
                    }
                    this.limpar()
                },
                iniciarCampo(evento, indice, zona) {
                    evento.stopPropagation()
                    this.campo = indice
                    this.zona = zona
                    evento.dataTransfer.effectAllowed = 'move'
                    evento.dataTransfer.setData('text/plain', indice)
                },
                passarCampo(evento, indice, zona) {
                    if (this.campo === null) return
                    if (this.zona !== zona) { this.sobreCampo = null; return }
                    evento.stopPropagation()
                    evento.preventDefault()
                    this.sobreCampo = indice
                },
                soltarCampo(evento, zona) {
                    if (this.campo === null || this.zona !== zona) return
                    evento.stopPropagation()
                    evento.preventDefault()
                    if (this.sobreCampo !== null && this.campo !== this.sobreCampo) {
                        $wire.reordenar(this.mover(this.indices(this.ordem()), this.campo, this.sobreCampo))
                    }
                    this.limpar()
                },
                limpar() { this.origem = null; this.sobre = null; this.campo = null; this.sobreCampo = null; this.zona = null },
            }"
            x-on:dragend="limpar()"
            class="flex flex-col gap-3">

            @foreach ($this->itens() as $posicao => $item)
                @php $primeiro = $campos[$item['indices'][0]]; @endphp

                @if ($item['noTopo'])
                    @php $indice = $item['indices'][0]; @endphp

                    <div wire:key="item-{{ $primeiro['chave'] }}" data-item="{{ $posicao }}"
                        data-indices="{{ implode(',', $item['indices']) }}"
                        x-data="{ arrastavel: true }"
                        x-bind:draggable="arrastavel"
                        x-on:dragstart="iniciarCampo($event, '{{ $indice }}', 'topo')"
                        x-on:dragover="passarCampo($event, '{{ $indice }}', 'topo')"
                        x-on:drop="soltarCampo($event, 'topo')"
                        x-bind:class="{
                            'opacity-40': campo === '{{ $indice }}',
                            'ring-2 ring-primary-accent': sobreCampo === '{{ $indice }}' && campo !== '{{ $indice }}',
                        }"
                        class="rounded-lg bg-on-surface p-4 transition-colors hover:bg-on-surface/70 cursor-grab active:cursor-grabbing">
                        @include('components.stateful-forms.partials.campo-template', [
                            'campo' => $primeiro,
                            'indice' => $indice,
                            'numero' => null,
                        ])
                    </div>
                @else
                    <div wire:key="item-{{ $primeiro['chave'] }}" data-item="{{ $posicao }}"
                        data-indices="{{ implode(',', $item['indices']) }}"
                        x-data="{ arrastavel: true }"
                        x-bind:draggable="arrastavel"
                        x-on:dragstart="iniciar($event, '{{ $posicao }}')"
                        x-on:dragover="passar($event, '{{ $posicao }}')"
                        x-on:drop="soltar($event)"
                        x-bind:class="{
                            'opacity-40': origem === '{{ $posicao }}',
                            'ring-2 ring-primary-accent': sobre === '{{ $posicao }}' && origem !== '{{ $posicao }}',
                        }"
                        class="rounded-lg bg-on-surface p-4 transition-colors hover:bg-on-surface/70 cursor-grab active:cursor-grabbing">

                        @if ($item['grupo'] !== null)
                            <div class="flex flex-col gap-3">
                                <p class="text-title-small">{{ CamposTemplate::titulo($numeros[$primeiro['chave']] ?? null, $item['titulo']) }}</p>

                                @foreach ($item['indices'] as $indice)
                                    <div wire:key="campo-{{ $campos[$indice]['chave'] }}"
                                        x-data="{ arrastavel: true }"
                                        x-bind:draggable="arrastavel"
                                        x-on:dragstart="iniciarCampo($event, '{{ $indice }}', '{{ $item['grupo'] }}')"
                                        x-on:dragover="passarCampo($event, '{{ $indice }}', '{{ $item['grupo'] }}')"
                                        x-on:drop="soltarCampo($event, '{{ $item['grupo'] }}')"
                                        x-bind:class="{
                                            'opacity-40': campo === '{{ $indice }}',
                                            'ring-2 ring-primary-accent': sobreCampo === '{{ $indice }}' && campo !== '{{ $indice }}',
                                        }"
                                        class="rounded-lg bg-surface p-4">
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

                    <livewire:form.select label="Seção" name="nova_secao" appearance="outlined" size="large"
                        wire:model.live="novaSecao" :options="$this->secoes()" wire:key="nova-secao" />

                    @if (in_array(CamposTemplate::NOVA_SECAO, (array) $novaSecao, true))
                        <x-form.input label="Nome da nova seção" name="nova_secao_titulo" appearance="outlined" size="large"
                            wire:model="novaSecaoTitulo" wire:keydown.enter.prevent="adicionar" :error="$errors->first('novaSecaoTitulo')" />
                    @endif

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
