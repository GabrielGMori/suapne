@props([
    'filled' => true,
    'label' => '',
    'color' => 'info',
])

@php
    $variant = $filled == true ? 'filled' : 'unfilled';
@endphp

<span {{ $attributes->merge(['class' => "badge badge-$variant badge-$variant-$color"]) }}>
    {{ $label ?? $slot }}
</span>
