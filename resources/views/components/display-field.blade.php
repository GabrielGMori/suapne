@props([
    'label' => '',
    'value' => '',
])

<div {{ $attributes->merge(['class' => 'display-field']) }}>
    @if ($label)
        <span class="display-field__label">{{ $label }}</span>
    @endif

    <span class="display-field__value">{{ $value ?: $slot }}</span>
</div>
