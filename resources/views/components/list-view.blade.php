@props([
    'title' => null,
    'items' => [],
    'columns' => [],
    'icon' => null,
    'image' => null,
    'actions' => [],

    'createUrl' => null,
    'createLabel' => 'Criar',
])

<div class="list-view-wrapper">
    <div class="list-view-card">
        <div class="list-view-header">
            @if($title) <h3>{{ $title }}</h3> @endif
            @if ($createUrl) 
                <x-button type="link" color="tertiary" 
                    href="{{ $createUrl }}"
                    label="{{ $createLabel }}"
                    icon="add" /> 
            @endif
        </div>

        <div class="list-view-columns">
            @foreach($columns as $column)
                <div class="list-view-column">
                    <span class="list-view-column-label">{{ $column['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="list-view-pagination">

    </div>
</div>