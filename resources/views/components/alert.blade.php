@props([
    'type' => 'success',
    'duration' => 4000,
])

@php
    $class = match ($type) {
        'success' => 'bg-green-50 text-green-800',
        'info' => 'bg-blue-50 text-blue-800',
        'danger' => 'bg-red-50 text-red-800',
        'warning' => 'bg-yellow-50 text-yellow-800',
        default => 'bg-blue-50 text-blue-800 dark:text-blue-400',
    };
@endphp

<div x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, {{ $duration }})" 
    x-show="show" 
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    {{ $attributes->merge(['class' => "fixed top-2 left-2 right-2 z-10 inline-flex items-center justify-between gap-2 p-4 mb-4 text-sm rounded-lg font-semibold  $class"]) }}
    role="alert">
    {{ $slot }}

    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 cursor-pointer" x-on:click="show = false">
        <path
            d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z">
        </path>
    </svg>
</div>
