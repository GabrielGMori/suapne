<nav role="navigation"
    class="flex items-center justify-between mt-4 text-label-small text-secondary">

    <div class="flex items-center gap-1.5 flex-1 justify-start">
        <span>Mostrando</span>
        <div class="relative">
            <select wire:model.live="perPage"
                class="appearance-none bg-transparent border border-secondary-accent/30 rounded-md px-2 py-1 pr-6 text-label-small outline-none focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer hover:border-secondary-accent/50 transition-colors">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-secondary">
                <x-icon size="14">arrow_drop_down</x-icon>
            </div>
        </div>
        <span>por página</span>
    </div>

    <div class="flex items-center gap-0.5 justify-center flex-1">
        @if ($paginator->hasPages())
            @if (!$paginator->onFirstPage())
                <button wire:click="previousPage" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-6 h-6 rounded-full text-secondary hover:text-primary transition-colors cursor-pointer">
                    <x-icon size="16">chevron_left</x-icon>
                </button>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-6 h-6 flex items-center justify-center text-secondary-accent">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="flex items-center justify-center min-w-6 h-6 px-1.5 text-primary-accent font-semibold"
                                aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                                class="flex items-center justify-center min-w-6 h-6 px-1.5 text-secondary hover:text-primary transition-colors cursor-pointer">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-6 h-6 rounded-full text-secondary hover:text-primary transition-colors cursor-pointer">
                    <x-icon size="16">chevron_right</x-icon>
                </button>
            @endif
        @else
            <span class="flex items-center justify-center min-w-6 h-6 px-1.5 text-black font-semibold" aria-current="page">
                {{ $paginator->currentPage() }}
            </span>
        @endif
    </div>

    <div class="font-medium text-black flex-1 text-right">
        {{ $paginator->total() }} resultados
    </div>

</nav>
