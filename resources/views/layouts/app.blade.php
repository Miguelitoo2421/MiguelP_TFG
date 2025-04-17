{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    {{-- Barra superior de Breeze (desktop) --}}
    @include('layouts.navigation')

    {{-- Pestaña móvil que abre el sidebar (solo < 640 px) --}}
    <button
        x-data                          {{-- ← añade esto --}}
        class="sm:hidden fixed top-4 left-4 z-50
            bg-gray-900 text-gray-100 px-3 py-2 rounded-r-lg
            font-semibold tracking-wide shadow-lg"
        @click="$dispatch('toggle-mobile-menu')"   {{-- ahora sí funciona --}}
    >
        Marvel Plays
    </button>

    <x-navigation.mobile-menu />


    {{-- Contenedor principal: sidebar + contenido --}}
    <div class="min-h-screen flex">
        {{-- Sidebar reutilizable (responsive) --}}
        <x-navigation.sidebar />

        {{-- Área de la página --}}
        <div class="flex-1 flex flex-col">
            {{-- Encabezado opcional de cada vista --}}
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Contenido principal --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')
</body>
</html>
