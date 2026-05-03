@props([
    'title' => '',
    'size' => 'md',
])

@php
    $sizeClass = [
        'sm' => 'auth-card--sm',
        'md' => 'auth-card--md',
        'lg' => 'auth-card--lg',
    ][$size] ?? 'auth-card--md';
@endphp

<section {{ $attributes->merge(['class' => "auth-card {$sizeClass}"]) }}>
    <h2 class="auth-card__title">{{ $title }}</h2>
    <div class="mt-8 w-full">
        {{ $slot }}
    </div>
</section>
