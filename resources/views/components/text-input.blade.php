@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:ring-primary rounded-md shadow-sm disabled:bg-gray-200']) }}>
