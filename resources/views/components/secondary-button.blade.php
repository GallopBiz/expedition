<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-indigo-500']) }}>
        {{ $slot }}
</button>
