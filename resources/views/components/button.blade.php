@props([
    'color' => 'primary',
    'size' => 'default',
    'icon' => null,
    'iconPos' => 'left',
    'text' => null,
    'type' => 'button',
])

@php
    $iconSize = "26px";
    if (isset($icon) && !isset($text)) {
        $size = "icon";
        $iconSize = "32px";
    }
@endphp

<button type="{{ $type }}" class='{{"btn btn-$size btn-$color"}}'>
    @if ($type == 'link') <a> @endif

    @if ($icon && $iconPos === 'left')
        <span class="material-symbols-outlined" style="font-size: {{ $iconSize }};">{{ $icon }}</span>
    @endif

    @if ($text || $slot->isNotEmpty())
        <span>{{ $text ?? $slot }}</span>
    @endif

    @if ($icon && $iconPos === 'right')
        <span class="material-symbols-outlined" style="font-size: {{ $iconSize }};">{{ $icon }}</span>
    @endif

    @if ($type == 'link') </a> @endif
</button>
