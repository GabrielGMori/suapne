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
    @include('components.⚡list-view.filters', [
        'filters' => $filters,
    ])

    <div class="list-view-card" wire:loading.class="opacity-50 transition-opacity duration-200">
        <div class="list-view-header">
            @if($title) <h3>{{ $title }}</h3> @endif
            @if ($createUrl)
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
                    <p class="{{ $i == 0 ? 'border-l-2' : '' }} list-view-size-{{ $column->getSize() }}">{{ $column->getLabel() }}</p>
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
                                <img class="h-16 rounded-[100%]" src="{{ $resolvedIcon }}">
                            @else
                                <x-icon class="w-full" size="40">{{ $resolvedIcon }}</x-icon>
                            @endif
                        </div>

                        <div class="list-view-item-data">
                            @foreach ($columns as $column)
                                <div class="list-view-size-{{ $column->getSize() }} text-center">
                                    {{ $column->getFormattedValue($item) }}
                                </div>
                            @endforeach
                        </div>

                        @if(count($actions) > 0)
                            <div class="min-w-40 text-center flex items-center justify-center gap-2">
                                @foreach ($actions as $action)
                                    @if(!$action->isLink())
                                        <form action="{{ $action->getUrl($item) }}" method="{{ $action->getMethod() === 'GET' ? 'GET' : 'POST' }}">
                                            @csrf
                                            @if($action->needsDirective())
                                                @method($action->getMethod())
                                            @endif
                                            <x-button type="submit" :icon="$action->getIcon()" :color="$action->getColor()" size="dynamic"></x-button>
                                        </form>
                                    @else
                                        <x-button type="link" :href="$action->getUrl($item)" :icon="$action->getIcon()" :color="$action->getColor()" size="dynamic"></x-button>
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
            {{ $items->links('components.paginacao') }}
        </div>
    @endif
</div>
