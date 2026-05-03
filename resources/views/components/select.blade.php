@props([
    'name' => '',
    'placeholder' => 'Selecione',
    'options' => [],
    'value' => '',
    'multiple' => false,
])

@php
    $submittedName = $multiple && $name && !str_ends_with($name, '[]') ? "{$name}[]" : $name;
@endphp

<div class="relative inline-block">
    <select
        name="{{ $submittedName }}"
        id="{{ $name }}"
        @if ($multiple) multiple @endif
        {{ $attributes->merge(['class' => 'form-control form-control--soft ' . ($multiple ? 'form-control--multiselect' : 'form-control--select') . ' min-w-70 cursor-pointer']) }}
    >
        @if($placeholder && !$multiple)
            <option value="" disabled {{ $value === '' ? 'selected' : '' }}>{{ $placeholder }}</option>
        @endif

        @foreach($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" {{ $value == $optValue ? 'selected' : '' }}>
                {{ $optLabel }}
            </option>
        @endforeach

        {{ $slot }}
    </select>

    @unless ($multiple)
        <span class="form-caret"></span>
    @endunless
</div>
