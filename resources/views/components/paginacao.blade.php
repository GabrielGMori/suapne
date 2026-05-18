<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
    class="flex items-center justify-between mt-8 text-label-medium text-secondary">

    <div class="flex items-center gap-2 flex-1 justify-start">
        <span>Mostrando</span>
        <div class="relative">
            <select wire:model.live="perPage"
                class="appearance-none bg-transparent border border-secondary-accent/30 rounded-lg px-3 py-1.5 pr-8 outline-none focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer hover:border-secondary-accent/50 transition-colors">
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-secondary">
                <x-icon size="16">arrow_drop_down</x-icon>
            </div>
        </div>
        <span>resultados por página</span>
    </div>

    <div class="flex items-center gap-1 justify-center flex-1">
        @if ($paginator->hasPages())
            @if (!$paginator->onFirstPage())
                <button wire:click="previousPage" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-8 h-8 rounded-full text-secondary hover:text-primary transition-colors cursor-pointer"
                    aria-label="{{ __('pagination.previous') }}">
                    <x-icon size="20">chevron_left</x-icon>
                </button>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-8 h-8 flex items-center justify-center text-secondary-accent">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="flex items-center justify-center min-w-8 h-8 px-2 text-primary-accent font-semibold"
                                aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                                class="flex items-center justify-center min-w-8 h-8 px-2 text-secondary hover:text-primary transition-colors cursor-pointer"
                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-8 h-8 rounded-full text-secondary hover:text-primary transition-colors cursor-pointer"
                    aria-label="{{ __('pagination.next') }}">
                    <x-icon size="20">chevron_right</x-icon>
                </button>
            @endif
        @else
            <span class="flex items-center justify-center min-w-8 h-8 px-2 text-black font-semibold" aria-current="page">
                {{ $paginator->currentPage() }}
            </span>
        @endif
    </div>

    <div class="font-medium text-black flex-1 text-right">
        {{ $paginator->total() }} resultados encontrados
    </div>

</nav>