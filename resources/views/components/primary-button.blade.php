<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:ring-indigo-500']) }}>
    {{ $slot }}
</button>
