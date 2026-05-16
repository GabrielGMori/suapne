@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center gap-3 mt-6">
        {{-- Link para Página Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-on-surface/5 text-on-surface/20 cursor-not-allowed border border-transparent">
                <x-icon size="20">chevron_left</x-icon>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               rel="prev" 
               class="flex items-center justify-center w-10 h-10 rounded-xl bg-surface text-secondary hover:bg-primary hover:text-white border border-secondary-accent/20 transition-all duration-200 shadow-sm" 
               aria-label="{{ __('pagination.previous') }}">
                <x-icon size="20">chevron_left</x-icon>
            </a>
        @endif

        {{-- Elementos da Paginação --}}
        <div class="flex items-center gap-2">
            @foreach ($elements as $element)
                {{-- Separador de Reticências --}}
                @if (is_string($element))
                    <span class="w-10 h-10 flex items-center justify-center text-secondary-accent">{{ $element }}</span>
                @endif

                {{-- Array de Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="flex items-center justify-center min-w-10 h-10 px-3 rounded-xl bg-primary text-white text-label-medium shadow-md border border-primary" 
                                  aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" 
                               class="flex items-center justify-center min-w-10 h-10 px-3 rounded-xl bg-surface text-secondary hover:border-primary hover:text-primary border border-secondary-accent/20 transition-all duration-200 text-label-medium shadow-sm" 
                               aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Link para Próxima Página --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               rel="next" 
               class="flex items-center justify-center w-10 h-10 rounded-xl bg-surface text-secondary hover:bg-primary hover:text-white border border-secondary-accent/20 transition-all duration-200 shadow-sm" 
               aria-label="{{ __('pagination.next') }}">
                <x-icon size="20">chevron_right</x-icon>
            </a>
        @else
            <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-on-surface/5 text-on-surface/20 cursor-not-allowed border border-transparent">
                <x-icon size="20">chevron_right</x-icon>
            </span>
        @endif
    </nav>
@endif
