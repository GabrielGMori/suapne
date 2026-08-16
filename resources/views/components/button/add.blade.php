@props([
    'href' => null,
    'label' => 'Adicionar'
])

<x-button label="{{ $label }}" icon="add" color="tertiary" size="dynamic" type="link" href="{{ $href }}" />
