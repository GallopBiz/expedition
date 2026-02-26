<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Exyte') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        <style>
            :root {
                --primary-color: #01426a;
                --secondary-color: #00b5e2;
            }
            .btn, .form-button {
                background: var(--primary-color) !important;
                color: #fff !important;
                font-weight: 600;
                border-radius: 0.375rem;
                padding: 0.5rem 1.5rem;
                transition: background 0.2s;
                border: none;
            }
            .btn:hover, .form-button:hover {
                background: var(--secondary-color) !important;
                color: #fff !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            @isset($breadcrumb)
                <x-breadcrumb :items="$breadcrumb" />
            @endisset

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
        @stack('scripts')
    </body>
</html>
