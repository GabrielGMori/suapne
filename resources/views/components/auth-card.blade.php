@props([
    'title' => null, // Título do card. Se for nulo, o título não será exibido
])

<section {{ $attributes->merge(['class' => "flex flex-col gap-5 items-center justify-stretch rounded-3xl bg-primary-container px-17 pb-10 pt-15"]) }}>
    @if (isset($title))
        <h2 class="text-display-medium text-white mb-8">{{ $title }}</h2>
    @endif
    {{ $slot }}
</section>
