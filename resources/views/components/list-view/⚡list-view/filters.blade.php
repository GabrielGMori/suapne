@if(count($filters) > 0)
    <x-secao-expansivel.bottom class="mb-10" title="Filtros" :expanded="$filtersExpanded">

        <div class="flex flex-col gap-4">
            <div class="flex flex-wrap gap-4">
                @foreach(collect($filters)->filter(fn($f) => !$f->isHidden()) as $filter)
                    @include('components.list-view.⚡list-view.filter-input', [
                        'filter' => $filter,
                        'prefix' => 'filter-',
                    ])
                @endforeach
            </div>
        </div>

        @if(collect($filters)->contains(fn($f) => $f->isHidden()))
            <x-slot:hidden>
                <div class="flex flex-wrap gap-4">
                    @foreach(collect($filters)->filter(fn($f) => $f->isHidden()) as $filter)
                        @include('components.list-view.⚡list-view.filter-input', [
                            'filter' => $filter,
                            'prefix' => 'filter-hidden-',
                        ])
                    @endforeach
                </div>
            </x-slot:hidden>
        @endif

        <x-slot:bottomActions>
            <x-button
                type="button"
                label="Limpar filtros"
                icon="filter_alt_off"
                color="secondary"
                size="dynamic"
                wire:click="clearFilters"
            />
        </x-slot:bottomActions>

    </x-secao-expansivel.bottom>
@endif
