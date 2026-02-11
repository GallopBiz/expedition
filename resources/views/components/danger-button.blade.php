<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-red-600 border border-transparent hover:bg-red-500 active:bg-red-700 focus:ring-red-500']) }}>
    {{ $slot }}
</button>
