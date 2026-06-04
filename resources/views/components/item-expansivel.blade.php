@props([
    'label',
    'items' => [],
    'expanded' => false
])

<div x-data="{ expanded: {{ filter_var($expanded, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false' }} }" {{ $attributes->merge(['class' => 'py-1']) }}>
    <button type="button" x-on:click="expanded = !expanded" class="flex items-center pl-5 justify-center w-full gap-1 font-medium text-black cursor-pointer hover:opacity-70 transition-opacity">
        <span class="text-body-medium">{{ $label }}</span>
        <x-icon icon="arrow_drop_down" size="24" class="transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
    </button>
    <div class="grid transition-[grid-template-rows] duration-300 ease-out mt-1" x-bind:class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
        <div class="overflow-scroll text-body-medium text-black text-center text-nowrap">
            @if(is_array($items))
                @if(count($items) > 0)
                    @foreach($items as $item)
                        <li class="mb-1">{{ $item }}</li>
                    @endforeach
                @endif
            @elseif(is_string($items) && !empty($items))
                <div class="py-1 whitespace-pre-wrap">{{ $items }}</div>
            @endif
            {{ $slot ?? '' }}
        </div>
    </div>
</div>
