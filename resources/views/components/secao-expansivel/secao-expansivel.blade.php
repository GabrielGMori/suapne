@props([
    'title' => '', // Título que aparece no topo da seção
    'expanded' => true, // Define se a seção começa expandida ou recolhida. Pode ser: true|false
])

<section
         data-initial-expanded="{{ filter_var($expanded, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false' }}"
         x-data="{ expanded: $el.dataset.initialExpanded === 'true' }"
         x-on:toggle-collapse.window="expanded = $event.detail.expand"
         {{ $attributes->merge(['class' => 'flex flex-col bg-surface rounded-xl overflow-visible']) }}>


        <div class="px-1">
            @if($title)
                <header class="flex justify-between items-center px-5 py-3">
                    <p class="text-display-small cursor-pointer" x-on:click="expanded = !expanded">{{ $title }}</p>
                    <div class="grow flex justify-end">
                        {{ $topActions ?? '' }}
                        <button type="button" class="flex items-center gap-1 text-black font-medium hover:opacity-70 transition-opacity cursor-pointer"  x-on:click="expanded = !expanded">
                            <x-icon icon="keyboard_arrow_down" size="40" class="transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                        </button>
                    </div>
                </header>
            @endif

            <div class="grid transition-[grid-template-rows] duration-300 ease-out" x-bind:class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                <div class="min-h-0 overflow-hidden relative">
                    <hr class="mx-4 text-on-surface">
                    {{ $slot }}
                </div>
            </div>
        </div>
</section>
