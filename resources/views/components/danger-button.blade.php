<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2 rounded-lg font-semibold transition bg-red-600 text-white hover:bg-red-700 active:bg-red-700 ']) }}>
    {{ $slot }}
</button>
