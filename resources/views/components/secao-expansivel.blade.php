@props([
    'title' => '',
    'expanded' => false,
])

<section x-data="{ expanded: {{ filter_var($expanded, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false' }} }" 
         {{ $attributes->merge(['class' => 'flex flex-col bg-surface rounded-xl overflow-hidden']) }}>
    
    @if($title)
        <header class="bg-primary text-white px-5 py-3 text-title-small">
            {{ $title }}
        </header>
    @endif

    <div class="px-6 pt-6 pb-5">
        {{ $slot }}
    </div>

    @if (isset($hidden) && $hidden->isNotEmpty())
        <div
            class="grid transition-[grid-template-rows] duration-300 ease-out"
            :class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'"
        >
            <div class="overflow-hidden min-h-0">
                <div class="px-6 pb-6 pt-4 mt-2">
                    {{ $hidden }}
                </div>
            </div>
        </div>

        <div class="flex justify-end px-4 py-3">
            <button type="button" class="flex items-center gap-1 text-black font-medium hover:opacity-70 transition-opacity cursor-pointer" @click="expanded = !expanded">
                <span x-text="expanded ? 'Recolher' : 'Expandir'"></span>
                <span class="material-symbols-outlined transition-transform duration-200" :class="expanded ? 'rotate-180' : ''">keyboard_arrow_down</span>
            </button>
        </div>
    @endif
</section>