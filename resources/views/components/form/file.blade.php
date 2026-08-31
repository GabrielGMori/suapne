@props([
    'label' => null,
    'helper' => null,
    'size' => 'medium',
    'appearance' => 'default',
    'error' => null,
])

@php
    $id = $attributes->get('id') ?? $attributes->get('name') ?? uniqid('file_');
    $classes = trim("form-control form-control-{$appearance} form-control-{$size} form-control-file");
@endphp

<div class="form-field {{ $size === 'full' ? '' : 'w-max' }}">
    @if ($label)
        <label for="{{ $id }}" class="form-label form-label-{{ $appearance }}">
            {{ $label }}
        </label>
    @endif

    <div class="form-control-wrap">
        <input
            {{ $attributes->merge(['class' => $classes . ($error ? ' form-control-error' : '')]) }}
            id="{{ $id }}"
            type="file"
        />

        <p wire:loading wire:target="{{ $attributes->wire('model')->value() }}">
            Enviando arquivo...
        </p>
    </div>

    <div class="h-5">
        @if ($error)
            <p class="text-error text-center form-control-{{ $size }} self-center text-body-small">
                {{ $error }}
            </p>
        @endif
    </div>

    @if ($helper)
        <p class="form-helper">
            {{ $helper }}
        </p>
    @endif
</div>
