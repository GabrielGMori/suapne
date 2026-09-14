@props(['title' => 'SUAPNE'])

<x-layouts.app title="{{ $title }}">
    <main class="flex flex-col items-center justify-center bg-linear-to-br from-primary to-primary-container min-h-screen h-auto">
        <div class="absolute top-0 left-0 right-0 flex justify-between items-center pl-10 pr-3 py-12.5">
            <img src="{{ asset('storage/img/logo-ifpr-light.png') }}" alt="IFPR Campus Curitiba"
                class="h-21.5 drop-shadow-lg">
            <img src="{{ asset('storage/img/logo-cnapne.png') }}" alt="CNAPNE" class="h-22.5 drop-shadow-lg">
        </div>

        <div class="py-20">
            @if(session('status'))
                <div
                    class="flex items-center rounded-3xl mb-5 justify-center h-9 w-full text-center text-body-medium bg-primary-accent/20 text-primary-accent">
                    {{ session('status') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <x-footer :full="false" />
</x-layouts.app>
