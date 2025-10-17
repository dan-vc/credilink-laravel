<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-3 bg-primary rounded-md font-semibold text-white hover:bg-secondary focus:bg-secondary active:bg-secondary']) }}>
    {{ $slot }}
</button>
