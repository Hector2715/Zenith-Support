<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-[#1e3d6c] border border-transparent rounded-lg font-black text-xs text-white uppercase tracking-widest hover:bg-[#41bcb0] active:bg-[#1e3d6c] focus:outline-none focus:ring-2 focus:ring-[#41bcb0] focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg']) }}>
    {{ $slot }}
</button>