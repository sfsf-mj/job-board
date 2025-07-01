<button {{ $attributes->merge(['type' => 'submit', 'class' => 'justify-center bg-gradient-to-r from-indigo-500 to-rose-500 text-white py-2 px-4 rounded-lg transition hover:from-indigo-600 hover:to-rose-600']) }}>
    {{ $slot }}
</button>
