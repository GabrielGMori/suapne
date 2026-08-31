@props([
    'title' => '',
    'width' => 'xl',
    'name' => 'default-modal', // Used to listen for specific Livewire events
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

<div x-data="{ show: false }"
     x-on:close-modal.window="show = false"
     x-cloak>

    @if($attributes->get('label') || $attributes->get('icon'))
        <x-button x-on:click="show = true" {{ $attributes }} />
    @endif

    <div x-show="show" class="fixed inset-0 z-50" style="display: none;">
        <div class="absolute inset-0 bg-black/50" x-on:click="show = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative z-10 bg-white shadow-2xl rounded-xl {{ $widthClasses[$width] ?? $widthClasses['md'] }}" x-on:click.stop>

                <div class="flex items-center justify-between px-6 pt-4 pb-2">
                    <h2 class="text-headline-small">{{ $title }}</h2>
                    <x-button icon="close" x-on:click="show = false" color="transparent"/>
                </div>

                <div class="max-h-[70vh] overflow-y-auto px-6 pb-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
