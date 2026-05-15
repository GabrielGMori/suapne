@props([
    'icon' => null,
    'label' => null,
    'size' => 24,
    'color' => null,
    'textType' => 'display-medium',
])

<div class="flex items-center gap-1">
    <span {{ $attributes->merge(['class' => "material-symbols-outlined " . ($color ? "text-$color" : '')]) }} style="font-size: calc(var(--spacing) * {{ $size/4 }});">{{ $icon ?? $slot }}</span>
    @if (isset($label) && $label) <span class="text-{{ $textType }}"> {{ $label }} </span> @endif
</div>
