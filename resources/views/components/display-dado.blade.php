@props([
    'label' => '', // Label do dado
    'value' => '', // Valor do dado
])

<div {{ $attributes->merge(['class' => 'flex max-w-114 flex-col gap-2 border-b border-[#C5C5C5] pb-2']) }}>
    @if ($label)
        <p class="text-body-small text-secondary-accent">{{ $label }}</p>
    @endif

    <p>{{ $value ?: $slot }}</p>
</div>
