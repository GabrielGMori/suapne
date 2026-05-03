@props([
    'variant' => 'primary',
    'icon' => 'check',
    'label' => '',
    'type' => 'button',
])

@php
    $variantClass = [
        'primary' => 'icon-btn--primary',
        'danger' => 'icon-btn--danger',
        'dark' => 'icon-btn--dark',
    ][$variant] ?? 'icon-btn--primary';

@endphp

<button type="{{ $type }}" aria-label="{{ $label ?: $icon }}" title="{{ $label ?: $icon }}" {{ $attributes->merge(['class' => "icon-btn icon-btn--md {$variantClass}"]) }}>
    <span class="material-symbols-outlined text-[26px]">{{ $icon }}</span>
</button>
