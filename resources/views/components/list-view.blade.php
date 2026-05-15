<div class="list-view-wrapper">
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
                            <img class="min-w-30 text-center h-15" src="{{ $formattedIcon }}">
                        @else
                            <span class="material-symbols-outlined min-w-30 text-center" style="font-size: 2.5rem">{{ $formattedIcon }}</span>
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

    <div class="list-view-pagination">

    </div>
</div>
