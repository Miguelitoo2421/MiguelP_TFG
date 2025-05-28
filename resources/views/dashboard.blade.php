<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-wrapper-views>
        <div class="p-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-gray-900 rounded-lg shadow-lg p-8">
                    @if($events->isNotEmpty())
                        <div 
                            x-data="{
                                currentTime: {{ $currentTime }},
                                rotationInterval: {{ $rotationInterval }},
                                totalEvents: {{ $totalEvents }},
                                isPaused: false,
                                hoveredIndex: null,
                                shouldRefresh() {
                                    if (this.totalEvents <= 4) return false;
                                    const elapsedTime = Math.floor(Date.now() / 1000) - this.currentTime;
                                    return elapsedTime >= this.rotationInterval;
                                }
                            }"
                            x-init="setInterval(() => {
                                if (shouldRefresh()) {
                                    window.location.reload();
                                }
                            }, 1000)"
                        >
                            {{-- Carrusel 3D (Desktop) --}}
                            <div class="hidden sm:block">
                                <div class="relative h-[400px] flex items-center justify-center">
                                    <div class="carousel relative w-full h-full [perspective:1000px] [transform-style:preserve-3d]">
                                        <div 
                                            class="carousel-items relative w-full h-full [transform-style:preserve-3d] will-change-transform"
                                            :class="{ 'animation-paused': isPaused }"
                                        >
                                            @foreach($events as $index => $event)
                                                <div 
                                                    class="carousel-item absolute w-[250px] h-[160px] left-1/2 top-1/2 [transform-style:preserve-3d] [backface-visibility:hidden] [transform-origin:center]" 
                                                    style="--i:{{ $index }}; --total:{{ count($events) }}"
                                                    @mouseenter="hoveredIndex = {{ $index }}; isPaused = true"
                                                    @mouseleave="hoveredIndex = null; isPaused = false"
                                                >
                                                    <img
                                                        src="{{ $event->play->image_url }}"
                                                        alt="{{ $event->title }}"
                                                        class="w-full h-full object-cover rounded-lg shadow-lg brightness-85 transition-all duration-300 ease-in-out will-change-transform hover:brightness-100 hover:scale-105 hover:shadow-xl border border-white/30"
                                                    >
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Carrusel Simple (Móvil) --}}
                            <div class="sm:hidden">
                                <x-carousel-mobile :events="$events" :rotationInterval="$rotationInterval" />
                            </div>

                            {{-- Sección de información de eventos --}}
                            <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($events as $index => $event)
                                    <div 
                                        class="bg-gray-800 rounded-lg p-4 text-white transition-colors duration-300"
                                        :class="hoveredIndex === {{ $index }} ? 'bg-green-600/30' : ''"
                                        @mouseenter="hoveredIndex = {{ $index }}"
                                        @mouseleave="hoveredIndex = null"
                                    >
                                        <h3 class="font-semibold text-lg mb-2 truncate">{{ $event->title }}</h3>
                                        <div class="space-y-1 text-sm text-gray-300">
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $event->scheduled_at->format('d M Y') }}
                                            </p>
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $event->scheduled_at->format('H:i') }}
                                            </p>
                                            <a 
                                                href="https://www.google.com/maps?q={{ $event->location->latitude }},{{ $event->location->longitude }}"
                                                target="_blank"
                                                class="flex items-center hover:text-blue-400 transition-colors"
                                            >
                                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $event->location->city }}
                                                @if($event->location->province), {{ $event->location->province }}@endif
                                            </a>
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                                </svg>
                                                {{ $event->play->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <style>
                            .carousel-items {
                                animation: rotate {{ $rotationInterval }}s infinite linear;
                            }

                            .animation-paused {
                                animation-play-state: paused;
                            }

                            .carousel-item {
                                transform: translate(-50%, -50%) 
                                         rotateY(calc(360deg / var(--total) * var(--i))) 
                                         translateZ(300px);
                            }

                            @keyframes rotate {
                                0% {
                                    transform: rotateY(0);
                                }
                                100% {
                                    transform: rotateY(-360deg);
                                }
                            }

                            @keyframes marquee {
                                0% {
                                    transform: translateX(0);
                                }
                                100% {
                                    transform: translateX(-100%);
                                }
                            }
                            @keyframes marquee2 {
                                0% {
                                    transform: translateX(100%);
                                }
                                100% {
                                    transform: translateX(0);
                                }
                            }
                            .animate-marquee {
                                animation: marquee 30s linear infinite;
                            }
                            .animate-marquee2 {
                                animation: marquee2 30s linear infinite;
                            }
                        </style>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            No hay eventos disponibles
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-wrapper-views>
</x-app-layout>
