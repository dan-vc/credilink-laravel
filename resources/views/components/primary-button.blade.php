<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg font-semibold transition bg-primary text-white hover:bg-secondary hover:text-black']) }}>
    {{ $slot }}
</button>
