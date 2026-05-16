@props([
    'filled' => true, // Se o status é preenchido ou não. Pode ser: true|false
    'label' => '', // Texto dentro do status. Se não for fornecido, o texto do slot entre x-status será usado.
    'color' => 'info', // Cor do status. Pode ser: info|success|danger|warning|dark
])

@php
    $variant = $filled == true ? 'filled' : 'unfilled';
@endphp

<span {{ $attributes->merge(['class' => "badge badge-$variant badge-$variant-$color"]) }}>
    {{ $label ?? $slot }}
</span>
