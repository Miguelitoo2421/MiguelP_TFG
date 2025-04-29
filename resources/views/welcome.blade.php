<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" type="image/png"
      href="{{ asset('images/logo_barra_busqueda.png') }}"
      sizes="64x64 32x32 16x16">
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen">

  {{-- Header --}}
  <header class="fixed top-0 left-0 w-full flex justify-end p-6 z-20">
    @if (Route::has('login'))
      <nav class="space-x-4">
        @auth
          <a href="{{ url('/dashboard') }}"
             class="px-5 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
            Dashboard
          </a>
        @else
          <a href="{{ route('login') }}"
             class="px-5 py-2 bg-red-600 text-white rounded hover:bg-red-500 transition">
            Log in
          </a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="px-5 py-2 border border-red-600 text-red-600 rounded hover:bg-red-50 transition">
              Register
            </a>
          @endif
        @endauth
      </nav>
    @endif
  </header>

  {{-- Hero --}}
  <main class="relative h-screen overflow-hidden pt-[4.5rem]">
    <img
      src="{{ asset('images/spiderman_paralax.png') }}"
      alt="Marvel background"
      class="parallax absolute inset-0 w-full h-full object-cover"
    />
    {{-- overlay --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/60"></div>

    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-6 space-y-6"
         x-data
         x-intersect.enter="() => $el.classList.add('opacity-100','translate-y-0')"
         class="opacity-0 translate-y-8 transform transition-all duration-700">
      <h1 class="text-5xl lg:text-6xl font-bold text-white drop-shadow-lg">
        ¡Bienvenido a <span class="text-red-500">Marvel Plays!</span>
      </h1>
      <p class="max-w-xl text-lg text-white/90">
        Explora tu universo Marvel favorito con efectos inmersivos sin salir de tu navegador.
      </p>
      <a href="#features"
         class="inline-block bg-red-600 hover:bg-red-500 text-white font-medium text-lg px-8 py-3 rounded-lg shadow-lg transition">
        Comenzar ahora
      </a>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 w-full flex justify-center">
      <button @click="window.scrollTo({ top: window.innerHeight, behavior: 'smooth' })"
              class="animate-bounce text-white text-3xl">
        ↓
      </button>
    </div>
  </main>

  {{-- Sección de Features --}}
  <section id="features" class="py-20 bg-white dark:bg-[#0a0a0a]">
    <div class="max-w-6xl mx-auto px-6 lg:px-0">
      <h2 class="text-3xl lg:text-4xl font-semibold text-center mb-12">
        ¿Qué puedes hacer aquí?
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-6 bg-gray-50 dark:bg-[#161615] rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-medium mb-2">🎬 Vídeos y Tutoriales</h3>
          <p class="text-gray-600 dark:text-gray-400">
            Aprende sobre tus personajes favoritos con una biblioteca interactiva de clips y guías.
          </p>
        </div>
        <div class="p-6 bg-gray-50 dark:bg-[#161615] rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-medium mb-2">🕹️ Mini‑Juegos</h3>
          <p class="text-gray-600 dark:text-gray-400">
            Pon a prueba tus reflejos con minijuegos temáticos de Marvel.
          </p>
        </div>
        <div class="p-6 bg-gray-50 dark:bg-[#161615] rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-medium mb-2">📜 Noticias y Comics</h3>
          <p class="text-gray-600 dark:text-gray-400">
            Mantente al día con novedades, lanzamientos y descargas de cómics.
          </p>
        </div>
      </div>
    </div>
  </section>

  {{-- Footer simple --}}
  <footer class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
    © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
  </footer>

</body>
</html>
