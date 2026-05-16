@props([
    'title' => null, // Título do card. Se for nulo, o título não será exibido
    'width' => 'max', // Largura mínima do card. Pode ser qualquer valor do Tailwind
])

<section {{ $attributes->merge(['class' => "flex flex-col min-w-{$width} gap-5 items-center justify-stretch rounded-3xl bg-primary-container px-17 py-17.5"]) }}>
    @if (isset($title))
        <h2 class="text-display-medium text-white mb-8">{{ $title }}</h2>
    @endif
    {{ $slot }}
</section>
