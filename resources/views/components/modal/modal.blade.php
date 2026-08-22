@props([
    'title' => '', // Título da janela modal
    'width' => 'xl', // Tamanho da janela modal
    'show' => null,
])

@php
    $widthClasses = [
        'sm' => 'w-full max-w-sm',
        'md' => 'w-full max-w-md',
        'lg' => 'w-full max-w-lg',
        'xl' => 'w-full max-w-xl',
        '2xl' => 'w-full max-w-2xl',
    ];
@endphp

<div x-data="{ show: {{ $show ?? 'false' }} }" x-cloak>
    <x-button x-on:click="show=true" {{ $attributes }}/>

    <div x-show="show" class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/50" x-on:click="show=false"></div>

        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative z-10 bg-white shadow-2xl rounded-xl {{ $widthClasses[$width] ?? $widthClasses['md'] }}" x-on:click.stop>

                <div class="flex items-center justify-between px-6 pt-4 pb-2">
                    <h2 class="text-headline-small">{{ $title }}</h2>
                    <x-button icon="close" x-on:click="show=false" color="transparent"/>
                </div>

                <div class="max-h-[70vh] overflow-y-auto px-6 pb-4 ">{{ $slot }}</div>

            </div>
        </div>
    </div>
</div>
