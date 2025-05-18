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

  <style>
    @font-face {
      font-family: 'BarberChop';
      src: url('/fonts/BarberChop.otf') format('opentype');
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }

    .barber-font {
      font-family: 'BarberChop', sans-serif;
      letter-spacing: 0.05em;
    }

    /* Estilos para marquee continuo */
    .animate-marquee {
      display: flex;
      white-space: nowrap;
      will-change: transform;
    }
    .animate-marquee p {
      margin: 0 2rem;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen">

  {{-- Header --}}
  <header class="fixed top-0 left-0 w-full flex justify-end p-6 z-20">
    @if (Route::has('login'))
      <nav class="space-x-4">
        @auth
          <a href="{{ url('/dashboard') }}"
             class="barber-font text-lg px-5 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
            Dashboard
          </a>
        @else
          <a href="{{ route('login') }}"
             class="barber-font text-lg px-5 py-2 bg-red-600 text-white rounded hover:bg-red-500 transition">
            Log in
          </a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="barber-font text-lg px-5 py-2 border border-red-600 text-red-600 rounded hover:bg-red-50 transition">
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
      <h1 class="barber-font text-6xl lg:text-7xl font-bold text-white drop-shadow-lg tracking-wider">
        Marvel <span class="text-red-500">Theater</span>
      </h1>
      
      <div class="w-full overflow-hidden bg-white/10 backdrop-blur-sm py-8">
        <div class="flex whitespace-nowrap animate-marquee">
          <div class="flex text-3xl mx-4">
            <p class="barber-font text-red-500">Manage your Marvel universe theater plays</p>
            <p class="barber-font text-blue-500">Organize spectacular events</p>
            <p class="barber-font text-red-500">Assign characters to your actors</p>
            <p class="barber-font text-blue-500">Control your show locations</p>
          </div>
          <div class="flex text-3xl mx-4">
            <p class="barber-font text-red-500">Manage your Marvel universe theater plays</p>
            <p class="barber-font text-blue-500">Organize spectacular events</p>
            <p class="barber-font text-red-500">Assign characters to your actors</p>
            <p class="barber-font text-blue-500">Control your show locations</p>
          </div>
        </div>
      </div>

      <div class="flex gap-4">
        <a href="#carousel"
           class="barber-font inline-block bg-white/10 hover:bg-white/20 text-white text-xl px-8 py-3 rounded-lg shadow-lg backdrop-blur-sm transition">
          PLAYS
        </a>
      </div>
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
      <h2 class="barber-font text-4xl lg:text-5xl font-semibold text-center mb-12 text-white dark:text-white">
        Complete Theater Management
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-6 bg-gray-50 dark:bg-[#161615] rounded-xl shadow hover:shadow-lg transition">
          <h3 class="barber-font text-2xl font-medium mb-2 text-white dark:text-white">🎭 Plays & Characters</h3>
          <p class="text-white dark:text-white">
            Manage your theater plays and assign Marvel characters to your actors easily.
          </p>
        </div>
        <div class="p-6 bg-gray-50 dark:bg-[#161615] rounded-xl shadow hover:shadow-lg transition">
          <h3 class="barber-font text-2xl font-medium mb-2 text-white dark:text-white">📅 Events & Shows</h3>
          <p class="text-white dark:text-white">
            Schedule and manage your theater events with an intuitive calendar.
          </p>
        </div>
        <div class="p-6 bg-gray-50 dark:bg-[#161615] rounded-xl shadow hover:shadow-lg transition">
          <h3 class="barber-font text-2xl font-medium mb-2 text-white dark:text-white">📍 Locations</h3>
          <p class="text-white dark:text-white">
            Control the different venues where your shows will take place.
          </p>
        </div>
      </div>
    </div>
  </section>

  {{-- Carrusel de Eventos --}}
  <section id="carousel" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-0">
      <h2 class="barber-font text-4xl lg:text-5xl font-semibold text-center mb-12 text-black dark:text-black">
        Upcoming Shows
      </h2>

      <div class="relative overflow-hidden"
           x-data="{ 
             activeSlide: 0,
             slides: {{ $events->count() }},
             timer: null,
             init() {
               this.timer = setInterval(() => this.nextSlide(), 5000);
             },
             nextSlide() {
               this.activeSlide = (this.activeSlide + 1) % this.slides;
             },
             prevSlide() {
               this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides;
             }
           }">
        
        {{-- Slides Container --}}
        <div class="relative h-[400px] transition-transform duration-500 ease-out"
             :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
          <div class="absolute top-0 left-0 w-full h-full flex">
            @foreach($events as $index => $event)
              <div class="w-full h-full flex-shrink-0">
                <div class="relative w-full h-full">
                  <img src="{{ $event->play->image_url }}" 
                       alt="{{ $event->title }}"
                       class="w-full h-full object-cover">
                  <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                  <div class="absolute bottom-0 left-0 right-0 p-8">
                    <h3 class="barber-font text-3xl text-white mb-2">{{ $event->title }}</h3>
                    <div class="flex items-center gap-4 text-white/90">
                      <p class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $event->scheduled_at->format('M d, Y - H:i') }}
                      </p>
                      <p class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $event->location->city }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        {{-- Navigation Buttons --}}
        <button @click="prevSlide" 
                class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-black/75 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button @click="nextSlide"
                class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-black/75 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>

        {{-- Indicators --}}
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
          @foreach($events as $index => $event)
            <button @click="activeSlide = {{ $index }}"
                    :class="{ 'bg-white': activeSlide === {{ $index }}, 'bg-white/50': activeSlide !== {{ $index }} }"
                    class="w-2 h-2 rounded-full transition-colors"></button>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- Footer simple --}}
  <footer class="py-6 text-center text-white dark:text-white barber-font">
    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
  </footer>

  <!-- Script para marquee continuo -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const marquee = document.querySelector('.animate-marquee');
    // duplicamos contenido para continuidad
    marquee.innerHTML += marquee.innerHTML;

    let pos = 0;
    // velocidad en píxeles por frame (ajusta a tu gusto)
    const speed = 0.4;

    function tick() {
      pos -= speed;
      // reinicio suave cuando pasa media anchura
      if (pos <= -marquee.scrollWidth / 2) {
        pos = 0;
      }
      marquee.style.transform = `translateX(${pos}px)`;
      requestAnimationFrame(tick);
    }

    requestAnimationFrame(tick);
  });
  </script>

</body>
</html>
