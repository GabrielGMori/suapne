{{-- Esse é um componente mais complexo, por isso, ele utiliza uma classe PHP em app/View/Components/ListView.php --}}

<div {{ $attributes->merge(['class' => 'list-view-wrapper']) }}
    x-data="listView({items: @js($items), filters: @js($filters)})">
    @if($filters)
        <form method="GET" action="{{ url()->current() }}" x-ref="filterForm">
            <x-secao-expansivel class="mb-20" title="Filtros">
                <div class="flex items-center justify-end gap-3">
                    <x-button type="button" label="Limpar filtros" color="tertiary" size="dynamic" onClick="clearFilters()"></x-button>
                    <x-button type="submit" label="Filtrar" color="primary" size="dynamic"></x-button>
                </div>
                <div class="flex flex-wrap gap-4">
                    {{ $renderFilters() }}
                </div>

                @if($hasHiddenFilters())
                    <x-slot:hidden>
                        <div class="flex flex-wrap gap-4">
                            {{ $renderFilters(true) }}
                        </div>
                    </x-slot:hidden>
                @endif
            </x-secao-expansivel>
        </form>
    @endif

    <div class="list-view-card">
        <div class="list-view-header">
            @if($title) <h3>{{ $title }}</h3> @endif
            @if ($createUrl)
                <x-button type="link" color="tertiary"
                    href="{{ $createUrl }}"
                    label="{{ $createLabel }}"
                    icon="add" size="dynamic" />
            @endif
        </div>

        @if (count($items) > 0 && $items->isNotEmpty())
            <div class="list-view-columns">
                <div class="min-w-30 shrink-0"></div>

                @foreach($columns as $i => $column)
                    <p class="{{ $i == 0 ? 'border-l-2' : '' }} list-view-size-{{ $column->getSize() }}">{{ $column->getLabel() }}</p>
                @endforeach

                @if(isset($actions)) <div class="min-w-40 shrink-0"></div> @endif
            </div>

            <div class="list-view-items">
                @foreach($items as $i => $item)
                    <div class="list-view-item">
                        <div class="min-w-30 text-center shrink-0">
                            @php
                                $resolvedIcon = is_callable($icon) ? $icon($item) : $icon;
                            @endphp

                            @if ($imageIcon)
                                <img class="h-15 w-full object-contain" src="{{ $resolvedIcon }}">
                            @else
                                <x-icon class="w-full" size="40">{{ $resolvedIcon }}</x-icon>
                            @endif
                        </div>

                        <div class="list-view-item-data">
                            @foreach ($columns as $column)
                                <p class="list-view-size-{{ $column->getSize() }}">
                                    {{ $column->getFormattedValue($item) }}
                                </p>
                            @endforeach
                        </div>

                        @if(isset($actions))
                            <div class="min-w-40 text-center flex items-center justify-center gap-2">
                                @foreach ($actions as $action)
                                    @if(!$action->isLink())
                                        <form action="{{ $action->getUrl() }}" method="{{ $action->getMethod() === 'GET' ? 'GET' : 'POST' }}">
                                            @csrf
                                            @if($action->needsDirective())
                                                @method($action->getMethod())
                                            @endif
                                            <x-button type="submit" :icon="$action->getIcon()" :color="$action->getColor()" size="dynamic"></x-button>
                                        </form>
                                    @else
                                        <x-button type="link" :href="$action->getUrl()" :icon="$action->getIcon()" :color="$action->getColor()" size="dynamic"></x-button>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

        @else
            <p class="text-body-large mt-5">{{ $emptyMessage }}</p>
        @endif
    </div>

    @if($hasPagination() && $items->hasPages())
        <div class="list-view-pagination">
            {{ $items->appends(request()->query())->links('components.paginacao') }}
        </div>
    @endif
</div>

@once
<script>
    function listView() {
        return {
            clearFilters() {
                window.dispatchEvent(new CustomEvent('clear-all-filters'));
                window.location.href = window.location.pathname;
            }
        };
    }
</script>
@endonce
