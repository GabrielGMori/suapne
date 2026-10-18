<?php

use App\Enums\TipoFormularioEnum;
use App\Support\CamposTemplate;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public string $tipo;
    public array|string|int|null $templateId = null;
    public ?Model $registro = null;

    public string $secao = '';
    public string $etapa = '';
    public string $ate = '';
    public string $depois = '';
    public bool $apenasDefinicoes = false;

    public array $valores = [];

    public function mount(): void
    {
        $this->valores = (array) old('campos', $this->registro?->campos ?? []);
    }

    #[Computed]
    public function todos(): array
    {
        return CamposTemplate::camposParaFormulario(
            TipoFormularioEnum::from($this->tipo),
            $this->templateIdInt(),
            $this->registro,
            $this->valores,
        );
    }

    #[Computed]
    public function campos(): array
    {
        return CamposTemplate::filtrar($this->todos, $this->secao, $this->etapa, $this->ate, $this->depois);
    }

    #[Computed]
    public function numeros(): array
    {
        return CamposTemplate::numeracao(TipoFormularioEnum::from($this->tipo), $this->todos);
    }

    #[Computed]
    public function itens(): array
    {
        return CamposTemplate::agrupar(array_values(array_filter($this->campos, fn($campo) => $campo['tipo'] !== 'especial')));
    }

    public function templateIdInt(): ?int
    {
        $id = is_array($this->templateId) ? (reset($this->templateId) ?: null) : $this->templateId;

        return filled($id) ? (int) $id : null;
    }
};
?>

@php
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
                    <h2 class="text-display-small">{{ CamposTemplate::titulo($this->numeros[$item['campos'][0]['chave']] ?? null, $item['titulo']) }}</h2>

                    @foreach ($item['campos'] as $campo)
                        @include('components.stateful-forms.partials.campo-adicional-input', [
                            'campo' => $campo,
                            'compacto' => true,
                        ])
                    @endforeach
                </div>
            @elseif ($dentroDeSecao)
                @include('components.stateful-forms.partials.campo-adicional-input', [
                    'campo' => $item['campo'],
                    'compacto' => true,
                ])
            @else
                @php $campo = $item['campo']; @endphp
                <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:key="campo-{{ $campo['chave'] }}">
                    <h2 class="text-display-small">{{ CamposTemplate::titulo($this->numeros[$campo['chave']] ?? null, $campo['rotulo']) }}</h2>

                    @if (!empty($campo['descricao']))
                        <h3 class="text-body-large text-secondary-accent">{{ $campo['descricao'] }}</h3>
                    @endif

                    @include('components.stateful-forms.partials.campo-adicional-input', [
                        'campo' => $campo,
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
    @endif
</div>
