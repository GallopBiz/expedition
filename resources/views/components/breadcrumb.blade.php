<nav aria-label="Breadcrumb" class="mb-4">
    <ol class="flex items-center space-x-2 text-sm">
        @foreach($items as $item)
            <li class="flex items-center">
                @if(!$loop->last)
                    <a href="{{ $item['url'] }}" class="px-2 py-1 rounded bg-white shadow-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">
                        {{ $item['label'] }}
                    </a>
                    <svg class="mx-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                @else
                    <span class="px-2 py-1 rounded bg-blue-50 text-blue-700 font-semibold shadow-sm">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
