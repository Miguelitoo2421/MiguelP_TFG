{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Prevent flash of unstyled content -->
  <style>
    [x-cloak] { display: none !important; }
  </style>

  <!-- Google Maps JavaScript API -->
  <script
    loading="lazy"
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"
  ></script>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
  <x-sidebar-plays-button>Marvel Plays</x-sidebar-plays-button>

  @include('layouts.navigation')

  <div class="flex h-screen overflow-hidden">
    <x-navigation.sidebar
      class="w-64 flex-shrink-0 bg-white border-r h-full sticky top-0 overflow-auto"
    />

    <div class="flex-1 flex flex-col overflow-auto">
      @isset($header)
        <header class="bg-white shadow">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
          </div>
        </header>
      @endisset

      <main class="flex-1 p-6 overflow-auto">
        {{ $slot }}
      </main>
    </div>
  </div>

  @stack('modals')
  @stack('scripts')
</body>
</html>
