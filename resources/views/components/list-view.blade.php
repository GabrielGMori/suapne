<div {{ $attributes->merge(['class' => 'list-view-wrapper']) }}>
    @if($filters)
        <x-secao-expansivel class="mb-20" title="Filtros">
            <div class="flex gap-4">
                @foreach ($filters['visible'] as $filter)
                    @php
                        $label = $filter['label'];
                        $type = $filter['type'];
                        $default = $filter['default'] ?? '';
                        $options = $filter['options'] ?? [];
                        $size = $filter['size'] ?? 'medium';
                        $placeholder = $filter['placeholder'] ?? null;
                    @endphp

                    <x-form-input :label="$label" :type="$type" :value="$default" :options="$options" :size="$size" :placeholder="$placeholder" appearance="outlined" />
                @endforeach
            </div>

            <x-slot:hidden>

            </x-slot:hidden>
        </x-secao-expansivel>
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

        @if (isset($items) && !empty($items))
            <div class="list-view-columns">
                <div class="min-w-30 shrink-0"></div>

                @foreach($columns as $i => $column)
                    @php
                        $label = $column['label'];
                        $size = $column['size'] ?? 'medium';
                    @endphp

                    <p class="{{ $i == 0 ? 'border-l-2' : '' }} list-view-size-{{ $size }}">{{ $label }}</p>
                @endforeach
            </div>


            <div class="list-view-items">
                @foreach($items as $i => $item)
                    <div class="list-view-item">
                        @php
                            $formattedIcon = is_callable($icon) ? $icon($item) : $icon;
                        @endphp

                        @if ($imageIcon)
                            <img class="min-w-30 text-center h-15 shrink-0" src="{{ $formattedIcon }}">
                        @else
                            <x-icon class="min-w-30 text-center shrink-0" size="40">{{ $formattedIcon }}</x-icon>
                        @endif

                        <div class="list-view-item-data">
                            @foreach ($columns as $column)
                                @php
                                    $key = $column['key'];
                                    $format = $column['format'] ?? null;
                                    $value = data_get($item, $column['key']);
                                    if ($format) $value = $format($value);
                                @endphp

                                <p class="list-view-size-{{ $column['size'] ?? 'medium' }}">
                                    {!! $value !!}
                                </p>
                            @endforeach
                        </div>

                        @if(isset($actions))
                            <div class="min-w-30 text-center">
                                @foreach ($actions as $action)
                                    @php
                                        $actionUrl = $action['url'];
                                        $actionMethod = $action['method'] ?? null;
                                        $actionConfirm = $action['confirm'] ?? false;
                                        $actionIcon = $action['icon'] ?? null;
                                        $actionColor = $action['color'] ?? null;
                                    @endphp

                                    <form action="{{ $actionUrl }}">
                                        @if($actionMethod && $actionMethod !== 'GET' && $actionMethod !== 'POST')
                                            @csrf
                                            @method($actionMethod)
                                        @endif
                                        <x-button :type="$actionMethod ? 'submit' : 'link'" :href="$actionMethod ? null : $actionUrl" :icon="$actionIcon ?? 'open_in_new'" :color="$actionColor ?? 'transparent'" size="dynamic"></x-button>
                                    </form>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-body-large">{{ $emptyMessage }}</p class="text-body-large">
        @endif
    </div>

    @if($hasPagination() && $items->hasPages())
        <div class="list-view-pagination">
            {{ $items->links('components.paginacao') }}
        </div>
    @endif
</div>
