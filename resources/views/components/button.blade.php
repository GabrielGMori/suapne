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
    $iconSize = "26px";
    if (isset($icon) && !isset($label)) {
        $size = "icon";
        $iconSize = "32px";
    }
@endphp

<button type="{{ $type }}" class='{{"btn btn-$size btn-$color"}}'>
    @if ($type == 'link') <a href="{{ $href }}"> @endif

    @if ($icon && $iconPos === 'left')
        <span class="material-symbols-outlined" style="font-size: {{ $iconSize }};">{{ $icon }}</span>
    @endif

    @if ($label || $slot->isNotEmpty())
        <span>{{ $label ?? $slot }}</span>
    @endif

    @if ($icon && $iconPos === 'right')
        <span class="material-symbols-outlined" style="font-size: {{ $iconSize }};">{{ $icon }}</span>
    @endif

    @if ($type == 'link') </a> @endif
</button>
