<x-secao-expansivel>
    @foreach ($items as $item)
        {{ $slot->with('item', $item) }}
    @endforeach
</x-secao-expansivel>
