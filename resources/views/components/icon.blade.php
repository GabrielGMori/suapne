@props([
    'icon' => null,
    'label' => null,
    'size' => 24,
    'color' => null,
    'textType' => 'display-medium',
])

<div {{ $attributes->merge(['class' => "flex items-center gap-1"]) }}>
    <span class="material-symbols-outlined {{ $color ? "text-$color" : '' }}" style="font-size: {{ $size }}px;">{{ $icon ?? $slot }}</span>
    @if (isset($label) && $label) <span class="text-{{ $textType }}"> {{ $label }} </span> @endif
</div>
