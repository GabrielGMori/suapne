@props([
    'icon' => 'description',
    'title' => '',
    'buttonIcon' => 'description',
    'metadata' => [],
    'actions' => [],
])

<article {{ $attributes->merge(['class' => 'list-item']) }}>
    <div class="list-item__row">
        <div class="list-item__main">
            <span class="material-symbols-outlined text-[24px] shrink-0">
                {{ $icon }}
            </span>
            <span class="list-item__title">{{ $title }}</span>
            <button type="button" class="list-item__action" aria-label="Mais opções">
                <span class="material-symbols-outlined text-[20px]">more_horiz</span>
            </button>
        </div>

        @if (!empty($actions))
            <div class="list-item__meta">
                @foreach($actions as $action)
                    <a href="{{ $action['href'] ?? '#' }}"
                       title="{{ $action['label'] ?? '' }}"
                       class="list-item__action">
                        <span class="material-symbols-outlined text-[28px]">
                            {{ $action['icon'] ?? 'open_in_new' }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    @if (!empty($metadata))
        <div class="list-item__row mt-2">
            <span></span>
            <div class="list-item__meta">
                @foreach($metadata as $meta)
                    <span class="whitespace-nowrap">{{ $meta }}</span>
                @endforeach
            </div>
        </div>
    @endif
</article>
