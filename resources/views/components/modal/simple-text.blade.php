@props([
    'label' => 'Clique aqui!',
    'title' => '',
    'value' => ''
])

<x-modal title="{{ $title }}" {{ $attributes }} size="dynamic" height="small" color="transparent" label="{{ $label }}">
    @if (is_array($value))
        @foreach ($value as $item)
            <p class="whitespace-pre-line">{{ $item }}</p>
        @endforeach
    @else
        <p class="whitespace-pre-line">{{ $value }}</p>
    @endif
</x-modal>
