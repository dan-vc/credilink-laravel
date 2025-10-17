@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-2 px-5 py-2 font-semibold bg-white rounded-lg'
            : 'inline-flex items-center gap-2 px-5 py-2 font-semibold bg-gray-300 rounded-lg hover:bg-white transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
