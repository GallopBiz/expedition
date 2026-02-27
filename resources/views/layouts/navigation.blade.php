<nav x-data="{ open: false }" class="border-b border-gray-100" style="background-color: #01426a;">
   
    <style>
        .main-nav-link, .main-nav-link:visited {
            color: #fff !important;
            background: transparent;
            transition: background 0.2s, color 0.2s;
        }
        .main-nav-link:hover, .main-nav-link:focus {
            background: none !important;
            color: #fff !important;
            text-decoration: none !important;
            border-bottom: none !important;
        }
        .main-nav-dropdown > button {
            color: #fff !important;
            background: transparent;
            transition: background 0.2s, color 0.2s;
        }
        .main-nav-dropdown > button:hover, .main-nav-dropdown > button:focus {
            background: #ffffff02 !important;
            color: #ffffff !important;
        }
        /* Notification bell icon color */
        .notification-bell-icon {
            stroke: #00b5e2 !important;
        }
    </style>
    <!-- Primary Navigation Menu -->
    <div class="w-full px-4 sm:px-6 lg:px-12">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="/images/111.png" alt="Exyte Logo" class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <div class="flex items-center space-x-4">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="main-nav-link" style="border-bottom: none;">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        @if(Auth::user() && (Auth::user()->role === 'Manager' || Auth::user()->role === 'Expeditor'))
                            <!-- User Management Dropdown -->
                            <div x-data="{ open: false }" class="relative main-nav-dropdown">
                                <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition">
                                    User Management
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l5 5 5-5" /></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <x-dropdown-link :href="route('users.create')">Create User</x-dropdown-link>
                                        <x-dropdown-link :href="route('users.index')">All User</x-dropdown-link>
                                    </div>
                                </div>
                            </div>

                            <!-- Work Package Management Dropdown -->
                            <div x-data="{ open: false }" class="relative main-nav-dropdown">
                                <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition">
                                    Work Package Management
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l5 5 5-5" /></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        @if(Auth::user()->role === 'Manager')
                                            <x-dropdown-link href="/manager/expedition-v2">Create Work Package</x-dropdown-link>
                                        @elseif(Auth::user()->role === 'Expeditor')
                                            <x-dropdown-link href="/expeditor/expedition-v2">Create Work Package</x-dropdown-link>
                                        @endif
                                        <x-dropdown-link :href="route('expediting_forms.cards')">All Work Package (Cards)</x-dropdown-link>
                                        <x-dropdown-link href="/expediting/list">All Work Package (List)</x-dropdown-link>
                                    </div>
                                </div>
                            </div>

                            <!-- Old Menu Dropdown -->
                            <div x-data="{ open: false }" class="relative main-nav-dropdown">
                                <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition">
                                    Old Menu
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l5 5 5-5" /></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <x-dropdown-link :href="route('expediting_forms.create')">Expediting Form</x-dropdown-link>
                                        <x-dropdown-link :href="route('expediting_forms.list')">Work Package List</x-dropdown-link>
                                        <x-dropdown-link :href="route('expediting_forms.expediting_list')">Expediting List</x-dropdown-link>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Language Switcher -->
                <div class="relative mr-4" x-data="{ openLang: false }" @click.outside="openLang = false">
                    <button @click="openLang = !openLang" class="text-gray-500 hover:text-gray-700 focus:outline-none px-2 py-1 rounded-md border border-gray-300 bg-white flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" /></svg>
                        <span>{{ strtoupper(app()->getLocale()) }}</span>
                    </button>
                    <div x-show="openLang" x-transition class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg z-50" style="display: none;">
                        <form method="POST" action="{{ route('language.switch') }}" class="py-2">
                            @csrf
                            <button type="submit" name="lang" value="en" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'en' ? 'font-bold' : '' }}">English</button>
                            <button type="submit" name="lang" value="de" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'de' ? 'font-bold' : '' }}">Deutsch</button>
                        </form>
                    </div>
                </div>
                <!-- Notification Bell Icon -->
                @php $user = Auth::user(); @endphp
                @if($user)
                    <div class="relative mr-4" x-data="{ open: false, unread: {{ $user->notifications()->where('read', false)->count() }} }" @click.outside="open = false">
                        <button @click="
                            if (!open && unread > 0) {
                                fetch('{{ route('notifications.readAll') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                    },
                                }).then(() => { unread = 0; });
                            }
                            open = !open;
                        " class="text-gray-500 hover:text-gray-700 focus:outline-none relative">
                                <svg class="h-6 w-6 notification-bell-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <template x-if="unread > 0">
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full" x-text="unread"></span>
                            </template>
                        </button>
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-md shadow-lg z-50" style="display: none;">
                            <div class="py-2 max-h-96 overflow-y-auto">
                                @php
                                    $notifications = Auth::user()->notifications()->latest()->take(10)->get();
                                    $unreadCount = Auth::user()->notifications()->where('read', false)->count();
                                @endphp
                                @forelse($notifications as $notification)
                                    <a href="{{ $notification->url ?? '#' }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $notification->read ? '' : 'font-bold' }}">
                                        <div>{{ $notification->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $notification->body }}</div>
                                    </a>
                                @empty
                                    <div class="px-4 py-2 text-sm text-gray-500">No notifications</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>
                                @if(Auth::check() && Auth::user())
                                    {{ Auth::user()->name }}
                                @else
                                    Guest
                                @endif
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::user() && Auth::user()->role === 'Supplier')
                <x-responsive-nav-link :href="route('work_packages')" :active="request()->routeIs('work_packages')">
                    {{ __('Work Packages') }}
                </x-responsive-nav-link>
            @endif
            @if(Auth::user() && Auth::user()->role === 'Manager')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('Users') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.create')" :active="request()->routeIs('users.create')">
                    {{ __('Create User') }}
                </x-responsive-nav-link>
            @endif
            @if(Auth::user() && (Auth::user()->role === 'Manager' || Auth::user()->role === 'Expeditor'))
                <x-responsive-nav-link :href="route('expediting_forms.create')" :active="request()->routeIs('expediting_forms.create')">
                    {{ __('Expediting Form') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('expediting_forms.list')" :active="request()->routeIs('expediting_forms.list')">
                    {{ __('Work Package List') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('expediting_forms.expediting_list')" :active="request()->routeIs('expediting_forms.expediting_list')">
                    {{ __('Expediting List') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    @if(Auth::check() && Auth::user())
                        {{ Auth::user()->name }}
                    @else
                        Guest
                    @endif
                </div>
                <div class="font-medium text-sm text-gray-500">
                    @if(Auth::check() && Auth::user())
                        {{ Auth::user()->email }}
                    @else
                        &nbsp;
                    @endif
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
