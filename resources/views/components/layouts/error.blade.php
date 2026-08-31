@props(['code', 'title', 'description'])

<x-layouts.auth>
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-6 py-12 text-center">
        <h1 class="text-7xl md:text-9xl font-extrabold text-white drop-shadow-lg">{{ $code }}</h1>
        <h2 class="mt-6 text-2xl md:text-3xl font-bold text-white tracking-tight">{{ $title }}</h2>
        <p class="mt-4 text-white text-body-large max-w-100">{{ $description }}</p>

        <x-button label="Página inicial" type="link" href="/" class="mt-5"></x-button>
    </div>
</x-layouts.auth>
