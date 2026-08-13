@props([
    'label' => 'Clique aqui!',
    'title' => '',
    'value' => '',
])

<x-modal title="{{ $title }}" label="{{ $label }}" {{ $attributes }} size="dynamic" height="small" color="transparent">
    @if (is_array($value))
        @foreach ($value as $item)
            <p>{{ $item }}</p>
        @endforeach
    @else
        <p>{{ $value }}</p>
    @endif
</x-modal>
