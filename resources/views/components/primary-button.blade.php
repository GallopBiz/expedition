<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2', 'style' => 'background-color: #01426a; border: none; color: #fff; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; transition: background 0.2s;' ]) }} onmouseover="this.style.backgroundColor='#012a40'" onmouseout="this.style.backgroundColor='#01426a'">
    {{ $slot }}
</button>
