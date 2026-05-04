@props([
    'color' => 'primary',
    'size' => 'default',
    'icon' => null,
    'iconPos' => 'left',
    'text' => null,
    'type' => 'button',
])

<button type="{{ $type }}" class='{{"btn btn-$size btn-$color"}}'>
    @if ($type == 'link') <a> @endif

    @if ($icon && $iconPos === 'left')
        <span class="material-symbols-outlined text-[22px]">{{ $icon }}</span>
    @endif

    <span>{{ $text ?? $slot }}</span>

    @if ($icon && $iconPos === 'right')
        <span class="material-symbols-outlined text-[22px]">{{ $icon }}</span>
    @endif

    @if ($type == 'link') </a> @endif
</button>
