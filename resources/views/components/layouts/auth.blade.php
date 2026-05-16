@props(['title' => 'SUAPNE'])

<x-layouts.app :title="$title">
    <main class="flex flex-col items-center justify-center bg-linear-to-br from-primary to-primary-container h-screen">
        <div class="absolute top-0 left-0 right-0 flex justify-between items-center pl-10 pr-3 py-12.5">
            <img src="{{ asset('storage/img/logo-ifpr.png') }}" alt="IFPR Campus Curitiba"
                class="h-21.5 drop-shadow-lg">
            <img src="{{ asset('storage/img/logo-cnapne.png') }}" alt="CNAPNE" class="h-22.5 drop-shadow-lg">
        </div>

        {{ $slot }}
    </main>

    <x-footer :full="false" />
</x-layouts.app>
