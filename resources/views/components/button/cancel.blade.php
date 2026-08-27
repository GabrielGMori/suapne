@props([
    'color' => 'red',
    'label' => 'Cancelar',
    'fallback',
    'args' => null,
])

@php
    $route = $args !== null ? route($fallback, $args) : route($fallback);
@endphp

<x-button label="{{ $label }}" type="link" color="{{ $color }}"
    href="{{ url()->previous() !== url()->current() ? url()->previous() : $route }}" />
