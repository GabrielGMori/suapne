@props([
    'filled' => false,
    'text' => '',
    'color' => 'info',
])

@php
    $variant = $filled == true ? 'filled' : 'unfilled';
@endphp

<span class='{{"badge badge-$variant badge-$variant-$color"}}'>
    {{ $text ?? $slot }}
</span>
