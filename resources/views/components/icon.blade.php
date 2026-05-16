@props([
    'icon' => null, // Nome do ícone do Google Material Icons. Se não for fornecido, o texto do slot entre x-icon será usado.
    'size' => 24, // Tamanho do ícone em px.
    'color' => null, // Cor do ícone. Pode ser qualquer cor do theme.css, como primary, secondary, white, black, etc.
    'label' => null, // Texto opcional na frente no ícone.
    'textType' => 'display-medium', // Tipo do texto opcional. Pode ser qualquer tipo de texto do theme.css, como display-small, title-medium, body-large, etc.
])

<div class="flex items-center gap-1">
    <span {{ $attributes->merge(['class' => "material-symbols-outlined " . ($color ? "text-$color" : '')]) }} style="font-size: calc(var(--spacing) * {{ $size/4 }});">{{ $icon ?? $slot }}</span>
    @if (isset($label) && $label) <span class="text-{{ $textType }}"> {{ $label }} </span> @endif
</div>
