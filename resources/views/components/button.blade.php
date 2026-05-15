@props([
    'color' => 'primary',
    'size' => 'default',
    'icon' => null,
    'iconPos' => 'left',
    'label' => null,
    'type' => 'button',
    'href' => null,
])

@php
    $iconSize = "26";
    if (isset($icon) && (!isset($label) || empty($label) || !$label)) {
        $size = "icon";
        $iconSize = "32";
    }
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-$size btn-$color"]) }}>
    @if ($type == 'link') <a href="{{ $href }}"> @endif

    @if ($icon && $iconPos === 'left')
        <x-icon size="{{ $iconSize }}">{{ $icon }}</x-icon>
    @endif

    @if ($label || $slot->isNotEmpty())
        <span>{{ $label ?? $slot }}</span>
    @endif

    @if ($icon && $iconPos === 'right')
        <x-icon size="{{ $iconSize }}">{{ $icon }}</x-icon>
    @endif

    @if ($type == 'link') </a> @endif
</button>
