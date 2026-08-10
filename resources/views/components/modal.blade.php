@props([
    'title' => '', // Título da janela modal
    'size' => 'xl', // Tamanho da janela modal
])

<div x-data="{ show: false }">
    <x-button x-on:click="show=true" {{ $attributes }}/>

    <div x-show="show" class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/50" x-on:click="show=false"></div>

        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-{{ $size }} bg-white shadow-2xl rounded-xl" x-on:click.stop>

                <div class="flex items-center justify-between px-6 pt-4 pb-2">
                    <h2 class="text-headline-small">{{ $title }}</h2>
                    <x-button icon="close" x-on:click="show=false" color="transparent" />
                </div>

                <div class="max-h-[70vh] overflow-y-auto px-6 py-2">
                    {{ $slot }}
                </div>

            </div>
        </div>
    </div>
</div>