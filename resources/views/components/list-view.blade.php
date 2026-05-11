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
                        @if ($iconType == 'image') 
                            <img src="{{ $icon }}">
                        @else
                            <span class="material-symbols-outlined min-w-30 text-center" style="font-size: 2.5rem">{{ $icon }}</span>
                        @endif

                        <div class="list-view-item-data">
                            @foreach ($columns as $column)
                                @php
                                    $key = $column['key'];
                                    $format = $column['format'] ?? null;
                                    $value = data_get($item, $column['key']);
                                    if ($format) $value = $format($value);
                                @endphp

                                <p class="list-view-size-{{ $column['size'] ?? 'medium' }}">{{ $value }}</p>
                            @endforeach
                        </div>

                        @if(isset($actions))
                            <div class="min-w-30 text-center">
                                @foreach ($actions as $action)
                                    @php
                                        $url = $action['url'];
                                        $method = $action['method'] ?? null;
                                        $confirm = $action['confirm'] ?? false;
                                        $icon = $action['icon'] ?? null;
                                        $color = $action['color'] ?? null;
                                    @endphp

                                    <form action="{{ $url }}">
                                        @if($method && $method !== 'GET' && $method !== 'POST')
                                            @csrf
                                            @method($method)
                                        @endif
                                        <x-button :type="$method ? 'submit' : 'link'" :href="$method ? null : $url" :icon="$icon ?? 'open_in_new'" :color="$color ?? 'transparent'" size="dynamic"></x-button>
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