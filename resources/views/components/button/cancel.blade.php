@props([
    'color' => 'red',
    'label' => 'Cancelar',
    'fallback',
    'args' => null,
])

@php
    $route = $args !== null ? route($fallback, $args) : route($fallback);

    $previousUrl = url()->previous();
    $currentUrl = url()->current();

    $cancelUrl = $previousUrl !== $currentUrl ? $previousUrl : $route;
@endphp

<x-button
    label="{{ $label }}"
    type="link"
    color="{{ $color }}"
    href="{{ $cancelUrl }}"
/>
