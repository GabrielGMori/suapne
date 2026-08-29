@props([
    'label' => 'Ver mudanças',
    'title' => 'Modificado',
    'modified' => [],
])

<x-modal
    title="{{ $title }}"
    {{ $attributes }}
    size="dynamic"
    height="small"
    color="transparent"
    label="{{ $label }}"
>
    <div>
        @foreach ($modified as $attribute => $values)
            <details class="mb-3">
                <summary class="cursor-pointer text-left">
                    <b>{{ str_replace('_id', '', $attribute) }}</b>
                </summary>

                <div class="mt-2 ml-4">
                    @if (array_key_exists('old', $values) && array_key_exists('new', $values))
                        <p class="text-left">
                            <b>Antes:</b>
                            {{ App\Support\Formatter::format($attribute, $values['old']) ?? '—' }}
                        </p>

                        <p class="text-left">
                            <b>Depois:</b>
                            {{ App\Support\Formatter::format($attribute, $values['new']) ?? '—' }}
                        </p>
                    @elseif (array_key_exists('new', $values))
                        <p class="text-left">
                            {{ App\Support\Formatter::format($attribute, $values['new']) ?? '—' }}
                        </p>
                    @else
                        <p class="text-left">
                            {{ App\Support\Formatter::format($attribute, $values['old']) ?? '—' }}
                        </p>
                    @endif
                </div>
            </details>
        @endforeach
    </div>
</x-modal>
