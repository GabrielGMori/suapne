@php
    use App\Support\CamposTemplate;

    $fixo = $campo['fixo'] ?? false;
    $rotuloTipo = CamposTemplate::formato($campo);
@endphp

<div x-data="{ aberto: false }">
    <div class="flex flex-wrap items-center gap-4">
        <div class="grow min-w-60">
            <p class="text-body-large">{{ CamposTemplate::titulo($numero, $campo['rotuloFormulario'] ?? $campo['rotulo']) }}</p>
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
                @include('components.stateful-forms.partials.previa-campo', ['campo' => $campo, 'numero' => $numero])
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
