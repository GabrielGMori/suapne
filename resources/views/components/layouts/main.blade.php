@props(['title' => 'SUAPNE', 'bg' => 'white', 'header' => null])

<x-layouts.app title="{{ $title }} - SUAPNE">
    <div class="flex flex-1">
        <x-menu-lateral />

        <main class="flex-1 px-20 py-5 bg-{{$bg}} mb-20">
            <h2>{{ $header ?? $title }}</h2>
            <hr class="mt-3 mb-5 text-on-surface">

            {{ $slot }}
        </main>
    </div>

    <x-footer />
</x-layouts.app>
