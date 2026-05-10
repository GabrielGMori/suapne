@props([
    'title' => null,
    'width' => 'max',
])

<section class="flex flex-col min-w-{{ $width }} gap-5 items-center justify-stretch rounded-3xl bg-primary-container px-17 py-17.5" >
    @if (isset($title))
        <h2 class="text-display-medium text-white mb-8">{{ $title }}</h2>
    @endif
    {{ $slot }}
</section>
