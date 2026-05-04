@props(['title' => 'SUAPNE', 'bg' => 'white'])

<x-layouts.app :title="$title">
    <div class="flex flex-1">
        <x-menu-lateral />

        <main class="flex-1 px-10 py-5 bg-{{$bg}}">
            {{ $slot }}
        </main>
    </div>

    <x-footer />
</x-layouts.app>
