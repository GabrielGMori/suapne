@props([
    'type' => null,
    'variant' => 'filled',
    'text' => null,
    'bg' => null,
    'color' => null,
    'border' => null,
])

@php
    $presetClasses = [
        'pendente' => 'badge--pending',
        'aguardando' => 'badge--waiting',
        'aprovado' => 'badge--approved',
        'removido' => 'badge--removed',
        'concluido' => 'badge--concluded',
        'previsualizacao' => 'badge--preview',
    ];

    $variantClass = $variant === 'outlined' ? 'badge--outlined' : 'badge--filled';
    $typeClass = $type && isset($presetClasses[$type]) ? $presetClasses[$type] : '';

    $styleMap = [];
    if ($bg) {
        $styleMap[] = "--badge-bg: {$bg}";
    }
    if ($color) {
        $styleMap[] = "--badge-color: {$color}";
    }
    if ($border) {
        $styleMap[] = "--badge-border: {$border}";
    }
    $styleAttr = implode('; ', $styleMap);
@endphp

<span
    {{ $attributes->merge(['class' => trim("badge {$variantClass} {$typeClass}")]) }}
    @if ($styleAttr !== '') style="{{ $styleAttr }}" @endif
>
    {{ $text ?? $slot }}
</span>
