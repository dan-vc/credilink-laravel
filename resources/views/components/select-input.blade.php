@props([
    'disabled' => false,
])

<select @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 focus:ring-primary rounded-md shadow-sm disabled:bg-gray-200 open-select-input']) }}>
    {{ $slot }}
</select>

<style>
    .open-select-input:open {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
</style>