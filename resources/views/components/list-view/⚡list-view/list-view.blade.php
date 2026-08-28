@php
    $cfg = $this->getConfigInstance();
    $items = $this->items;
    $columns = $cfg->columns();
    $actions = $cfg->actions();
    $filters = $cfg->filters();
    $icon = $cfg->icon();
    $imageIcon = $cfg->imageIcon();
@endphp

<div class="list-view-wrapper">
    @include('components.list-view.⚡list-view.filters', [
        'filters' => $filters,
        'filtersExpanded' => $filtersExpanded,
    ])

    <div class="list-view-card" wire:loading.class="opacity-50 transition-opacity duration-200">
        <div class="list-view-header">
            @if($title) <h3>{{ $title }}</h3> @endif
            @if ($createUrl && $canCreate)
                <x-button type="link" color="tertiary"
                    href="{{ $createUrl }}"
                    label="{{ $createLabel }}"
                    icon="add" size="dynamic" />
            @endif
        </div>

        @if ($items->isNotEmpty())
            <div class="list-view-columns">
                <div class="min-w-30 shrink-0"></div>

                @foreach($columns as $i => $column)
                    <p class="{{ $i === 0 ? 'border-l-2' : '' }} list-view-size-{{ $column->getSize() }}">{{ $column->getLabel() }}</p>
                @endforeach

                @if(count($actions) > 0) <div class="min-w-40 shrink-0"></div> @endif
            </div>

            <div class="list-view-items">
                @foreach($items as $item)
                    <div class="list-view-item">
                        <div class="min-w-30 text-center shrink-0 flex justify-center">
                            @php
                                $resolvedIcon = is_callable($icon) ? $icon($item) : $icon;
                            @endphp

                            @if ($imageIcon)
                                <img class="h-16 w-16 object-cover rounded-full shrink-0" src="{{ $resolvedIcon }}" alt="Ícone">
                            @else
                                <x-icon class="w-full" size="40">{{ $resolvedIcon }}</x-icon>
                            @endif
                        </div>

                        @foreach ($columns as $column)
                            <div class="list-view-size-{{ $column->getSize() }} text-center text-body-medium">
                                {{ $column->getFormattedValue($item) }}
                            </div>
                        @endforeach

                        @if(count($actions) > 0)
                            <div class="min-w-40 text-center flex items-center justify-center gap-2">
                                @foreach ($actions as $action)
                                    @if($action->needsConfirmation($item))
                                        <x-modal color="transparent" :icon="$action->getIcon($item)" title="Confirmar">
                                            <p class="mb-10 text-body-large">{{ $action->getConfirmMessage() }}</p>
                                            <div class="flex justify-end gap-3 mb-2">
                                                <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                                                @include('components.list-view.⚡list-view.action-button', ['action' => $action])
                                            </div>
                                        </x-modal>
                                    @else
                                        @include('components.list-view.⚡list-view.action-button', ['action' => $action])
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

    @if(method_exists($items, 'total') && $items->total() > 0)
        <div class="list-view-pagination">
            {{ $items->links('components.paginacao.paginacao') }}
        </div>
    @endif
</div>
