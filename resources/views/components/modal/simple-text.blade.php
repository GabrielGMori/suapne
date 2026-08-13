@props([
    'label' => 'Clique aqui!',
    'title' => '',
    'value' => ''
])

<x-modal title="{{ $title }}" {{ $attributes }} size="dynamic" height="small" color="transparent" label="{{ $label }}">
    @if (is_array($value))
        @foreach ($value as $item)
            <p>{{ $item }}</p>
        @endforeach
    @else
        <p>{{ $value }}</p>
    @endif
</x-modal>
