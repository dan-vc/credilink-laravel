@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-2 md:px-5 md:py-2 font-semibold md:bg-white md:rounded-lg scale-150 md:scale-100'
            : 'inline-flex items-center gap-2 md:px-5 md:py-2 font-semibold md:bg-gray-300 md:rounded-lg md:hover:bg-white transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
