@props([
    'title' => '',
    'expanded' => false,
    'summary' => [],
])

<section x-data="{ expanded: {{ $expanded ? 'true' : 'false' }} }" {{ $attributes->merge(['class' => 'surface-panel']) }}>
    <header class="surface-panel__header">
        {{ $title }}
    </header>

    @if (count($summary))
        <div class="surface-panel__summary">
            @foreach ($summary as $label => $value)
                <div class="surface-panel__summary-item">
                    <span class="surface-panel__summary-label">{{ $label }}:</span>
                    <span>{{ $value }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <div
        class="grid transition-[grid-template-rows] duration-300 ease-out"
        :class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'"
    >
        <div class="overflow-hidden">
            <div class="surface-panel__body">
                {{ $slot }}
            </div>
        </div>
    </div>

    <button type="button" class="surface-panel__toggle w-full" @click="expanded = !expanded">
        <span x-text="expanded ? 'Recolher' : 'Expandir'"></span>
        <span class="material-symbols-outlined text-[32px] transition-transform duration-200" :class="expanded ? 'rotate-180' : ''">keyboard_arrow_down</span>
    </button>
</section>
