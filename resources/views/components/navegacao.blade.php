<nav {{ $attributes->merge(['class' => 'flex items-center text-sm text-gray-500 gap-2']) }}>
    @foreach ($breadcrumbs as $breadcrumb)
        @if (!$loop->first)
            <span>&lt</span>
        @endif

        @if (isset($breadcrumb['url']))
            <a href="{{ $breadcrumb['url'] }}"
               class="hover:text-blue-600">
                {{ $breadcrumb['label'] }}
            </a>
        @else
            <span class="font-semibold text-gray-800">
                {{ $breadcrumb['label'] }}
            </span>
        @endif
    @endforeach
</nav>
