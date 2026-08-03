@props(['title' => 'SUAPNE', 'bg' => 'white', 'header' => null])

<x-layouts.app title="{{ $title }} - SUAPNE">
    <div class="flex flex-1">
        <x-menu-lateral/>

        <main class="flex-1 bg-{{$bg}} mb-20">
            @if(session('status'))
                <div class="flex items-center justify-center h-9 w-full text-center text-body-medium bg-primary-accent/20 text-primary-accent">
                    {{ session('status') }}
                </div>
            @endif

            <div class="px-20 py-5">
                <h2>{{ $header ?? $title }}</h2>
                <hr class="mt-3 mb-5 text-on-surface">
                    
                {{ $slot }}
            </div>
        </main>
    </div>

    <x-footer/>
</x-layouts.app>
