@props([
    'acao',
    'rotulo',
    'registro' => 'Formulários',
])

<button type="button" title="Remover campo"
    {{ $attributes->merge(['class' => 'shrink-0 flex items-center text-secondary-accent hover:text-red transition-colors cursor-pointer']) }}
    wire:click="{{ $acao }}"
    wire:confirm="Remover o campo '{{ $rotulo }}' deste estudante? {{ $registro }} já salvos não perdem o que foi preenchido.">
    <x-icon size="22">close</x-icon>
</button>
