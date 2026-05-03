@props(['title'])

<x-layouts.app :title="$title">
    <div class="flex flex-1">
        <x-menu-lateral />

        <main class="flex-1 px-10 py-5">
            {{ $slot }}
        </main>
    </div>

    <x-footer />
</x-layouts.app>
