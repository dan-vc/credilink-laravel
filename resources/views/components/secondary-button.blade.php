@props([
    'href' => null,
])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 px-5 py-2 rounded-lg font-semibold min-w-max transition bg-secondary text-white hover:bg-primary hover:text-white']) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2 rounded-lg font-semibold min-w-max transition bg-secondary text-white hover:bg-primary hover:text-white']) }}>
        {{ $slot }}
    </button>
@endif
