@props([
    'color' => 'primary', // Cor do botão. Pode ser: primary|secondary|tertiary|red|yellow|transparent
    'size' => 'default', // Tamanho do botão. Pode ser: default|dynamic|full|icon
    'height' => 'medium', // Altura do botão. Pode ser: small|medium
    'icon' => null, // Ícone do botão (usando Google Material Icons)
    'iconPos' => 'left', // Posição do ícone. Pode ser: left|right
    'label' => null, // Texto do botão
    'type' => 'button', // Tipo do botão. Pode ser: button|submit|link
    'href' => null, // URL para o tipo 'link'
    'onClick' => null // Função a ser chamada quando o botão for clicado
])

@php
    $iconSize = "26";
    if (isset($icon) && (!isset($label) || empty($label) || !$label)) {
        $size = "icon";
        $iconSize = "32";
    }
@endphp

<button
    type="{{ $type === 'link' ? 'button' : $type }}"
    {{ $attributes->merge(['class' => "btn btn-$size btn-$color btn-$height"]) }}
    @if($onClick) x-on:click="{{ $onClick }}" @endif
>
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
