<?php

use App\Enums\TipoFormularioEnum;
use App\Models\ModeloFormulario;
use App\Support\FormularioPadrao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public string $tipo;
    public array|string|int|null $estudanteId = null;
    public ?Model $registro = null;

    public string $secao = '';
    public string $etapa = '';
    public int $ordemMin = 0;
    public ?int $ordemMax = null;
    public bool $mostrarAdicionar = true;
    public bool $apenasDefinicoes = false;

    public array $valores = [];

    public bool $adicionando = false;
    public string $novoRotulo = '';
    public array|string|null $novoTipo = ['textarea'];
    public bool $novoObrigatorio = false;

    public function mount(): void
    {
        $this->valores = (array) old('campos', $this->registro?->campos ?? []);
    }

    public function adicionar(): void
    {
        abort_unless($this->podeEditar(), 403);

        $this->novoTipo = is_array($this->novoTipo) ? (string) (reset($this->novoTipo) ?: '') : (string) $this->novoTipo;

        $this->validate([
            'novoRotulo' => ['required', 'string', 'max:150'],
            'novoTipo' => ['required', 'in:' . implode(',', array_keys(FormularioPadrao::TIPOS_CAMPO))],
        ], [], ['novoRotulo' => 'nome do campo', 'novoTipo' => 'tipo']);

        $this->modelo()->adicionar($this->novoRotulo, $this->novoTipo, $this->novoObrigatorio);

        $this->reset('adicionando', 'novoRotulo', 'novoTipo', 'novoObrigatorio');
        $this->recarregar();
    }

    public function remover(string $chave): void
    {
        abort_unless($this->podeEditar(), 403);

        $this->modelo()->remover($chave);
        unset($this->valores[$chave]);
        $this->recarregar();
    }

    public function restaurarPadrao(): void
    {
        abort_unless($this->podeEditar(), 403);

        $this->modelo()->restaurarPadrao();
        $this->recarregar();
    }

    public function cancelarNovo(): void
    {
        $this->reset('adicionando', 'novoRotulo', 'novoTipo', 'novoObrigatorio');
        $this->resetValidation();
    }

    public function podeEditar(): bool
    {
        return $this->estudanteIdInt() !== null && Gate::allows('update', $this->modelo());
    }

    public function ehPadrao(): bool
    {
        return $this->modelo()->ehPadrao();
    }

    #[Computed]
    public function campos(): array
    {
        $todos = FormularioPadrao::camposParaFormulario(
            TipoFormularioEnum::from($this->tipo),
            $this->estudanteIdInt(),
            $this->registro,
            $this->valores,
        );

        return FormularioPadrao::filtrar($todos, $this->secao, $this->etapa, $this->ordemMin, $this->ordemMax);
    }

    #[Computed]
    public function itens(): array
    {
        return FormularioPadrao::agrupar(array_values(array_filter($this->campos, fn($campo) => $campo['tipo'] !== 'especial')));
    }

    private function recarregar(): void
    {
        unset($this->campos, $this->itens);
        $this->dispatch('campos-alterados');
    }

    private function modelo(): ModeloFormulario
    {
        return ModeloFormulario::para(TipoFormularioEnum::from($this->tipo), $this->estudanteIdInt());
    }

    public function estudanteIdInt(): ?int
    {
        $id = is_array($this->estudanteId) ? (reset($this->estudanteId) ?: null) : $this->estudanteId;

        return filled($id) ? (int) $id : null;
    }
};
?>

@php
    $podeEditar = $this->podeEditar();
    $dentroDeSecao = $secao !== '';
@endphp

<div>
    @if ($apenasDefinicoes)
        @foreach ($this->campos as $campo)
            <x-campo-extra-hidden :campo="$campo" :snapshot="true" />
        @endforeach
    @else
        @foreach ($this->itens as $item)
            @if (isset($item['grupo']))
                <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:key="grupo-{{ $item['grupo'] }}">
                    <h2 class="text-display-small">{{ $item['titulo'] }}</h2>

                    @foreach ($item['campos'] as $campo)
                        @include('components.stateful-forms.partials.campo-adicional-input', [
                            'campo' => $campo,
                            'podeEditar' => $podeEditar,
                            'compacto' => true,
                        ])
                    @endforeach
                </div>
            @elseif ($dentroDeSecao)
                @include('components.stateful-forms.partials.campo-adicional-input', [
                    'campo' => $item['campo'],
                    'podeEditar' => $podeEditar,
                    'compacto' => true,
                ])
            @else
                @php $campo = $item['campo']; @endphp
                <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:key="campo-{{ $campo['chave'] }}">
                    <div class="flex justify-between items-center gap-3">
                        <h2 class="text-display-small">{{ $campo['rotulo'] }}</h2>

                        @if ($podeEditar)
                            <x-botao-remover-campo acao="remover('{{ $campo['chave'] }}')" :rotulo="$campo['rotulo']" />
                        @endif
                    </div>

                    @if (!empty($campo['descricao']))
                        <h3 class="text-body-large text-secondary-accent">{{ $campo['descricao'] }}</h3>
                    @endif

                    @include('components.stateful-forms.partials.campo-adicional-input', [
                        'campo' => $campo,
                        'podeEditar' => false,
                        'compacto' => false,
                    ])
                </div>
            @endif
        @endforeach

        @foreach ($this->campos as $campo)
            @if ($campo['tipo'] !== 'especial')
                <x-campo-extra-hidden :campo="$campo" />
            @endif
        @endforeach

        @if ($mostrarAdicionar)
            @if ($podeEditar)
                <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5 border-2 border-dashed border-on-surface" wire:key="novo-campo">
                    @if (!$adicionando)
                        <div class="flex flex-wrap justify-center gap-3">
                            <x-button type="button" icon="add" label="Adicionar campo" color="secondary" size="dynamic"
                                wire:click="$set('adicionando', true)" />

                            @if (!$this->ehPadrao())
                                <x-button type="button" icon="history" label="Restaurar campos padrão" color="tertiary" size="dynamic"
                                    wire:click="restaurarPadrao"
                                    wire:confirm="Restaurar os campos padrão deste formulário para este estudante? Campos adicionados serão removidos e os removidos voltam. Formulários já salvos não são alterados." />
                            @endif
                        </div>
                    @else
                        <h3 class="text-title-small">Novo campo</h3>

                        <div class="flex flex-wrap items-end gap-5">
                            <x-form.input label="Nome do campo" name="novo_rotulo" appearance="outlined" size="large"
                                wire:model="novoRotulo" wire:keydown.enter.prevent="adicionar" :error="$errors->first('novoRotulo')" />

                            <livewire:form.select label="Tipo" name="novo_tipo" appearance="outlined" wire:model="novoTipo"
                                :options="FormularioPadrao::TIPOS_CAMPO" placeholder="Selecionar" wire:key="novo-tipo" />

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
            @elseif ($this->estudanteIdInt() === null)
                <p class="text-body-medium text-secondary-accent mb-5">Selecione o estudante para adicionar ou remover campos deste formulário.</p>
            @endif
        @endif
    @endif
</div>
