@props(['label', 'href' => '#'])

@php
    $resolvedHref = Route::has($href) 
        ? route($href) 
        : (str_contains($href, '/') || str_starts_with($href, '#') || str_starts_with($href, 'http') ? $href : '#');
@endphp

<a class="text-body-medium" href="{{ $resolvedHref }}">{{ $label }}</a>
