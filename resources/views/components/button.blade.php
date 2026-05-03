@props([
    'variant' => 'primary',
    'size' => 'wide',
    'icon' => null,
    'iconPosition' => 'left',
    'text' => null,
    'type' => 'button',
])

@php
    $variantClass = [
        'primary' => 'btn--primary',
        'info' => 'btn--info',
        'danger' => 'btn--danger',
        'warning' => 'btn--warning',
        'dark' => 'btn--dark',
    ][$variant] ?? 'btn--primary';

    $sizeClass = [
        'wide' => 'btn--wide',
        'medium' => 'btn--medium',
        'small' => 'btn--small',
    ][$size] ?? 'btn--wide';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn {$variantClass} {$sizeClass}"]) }}>
    @if ($icon && $iconPosition === 'left')
        <span class="material-symbols-outlined text-[22px]">{{ $icon }}</span>
    @endif
    <span>{{ $text ?? $slot }}</span>
    @if ($icon && $iconPosition === 'right')
        <span class="material-symbols-outlined text-[22px]">{{ $icon }}</span>
    @endif
</button>
