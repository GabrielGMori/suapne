@props([
    'title' => '', // Título que aparece no topo da seção
    'expanded' => false, // Define se a seção começa expandida ou recolhida. Pode ser: true|false
])

<section
         data-initial-expanded="{{ filter_var($expanded, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false' }}"
         x-data="{ expanded: $el.dataset.initialExpanded === 'true' }"
         {{ $attributes->merge(['class' => 'flex flex-col bg-surface rounded-xl overflow-visible']) }}>

    @if($title)
        <header class="bg-primary text-white px-5 py-3 text-title-small rounded-t-xl">
            {{ $title }}
        </header>
    @endif

    <div class="px-6 pt-6 pb-5">
        {{ $slot }}
    </div>

    @if (isset($hidden) && $hidden->isNotEmpty())
        <div
            class="grid transition-[grid-template-rows] duration-300 ease-out"
            x-bind:class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'"
        >
            <div class="min-h-0" x-bind:class="expanded ? 'overflow-visible' : 'overflow-hidden'">
                <div class="px-6 pb-6 pt-4 mt-2">
                    {{ $hidden }}
                </div>
            </div>
        </div>

        <div class="flex justify-end px-4 py-3">
            <button type="button" class="flex items-center gap-1 text-black font-medium hover:opacity-70 transition-opacity cursor-pointer" x-on:click="expanded = !expanded">
                <span x-text="expanded ? 'Recolher' : 'Expandir'"></span>
                <span class="material-symbols-outlined transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''">keyboard_arrow_down</span>
            </button>
        </div>
    @endif
</section>
