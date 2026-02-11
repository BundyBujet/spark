@props(['name' => ''])
@php
    $tagName = strtolower((string) $name);
    $iconClass = match(true) {
        str_contains($tagName, 'work') => 'ri-briefcase-4-line',
        str_contains($tagName, 'personal') => 'ri-user-line',
        str_contains($tagName, 'important') => 'ri-star-line',
        str_contains($tagName, 'social') => 'ri-team-line',
        default => 'ri-price-tag-3-line',
    };
@endphp
<i {{ $attributes->merge(['class' => $iconClass]) }}></i>
