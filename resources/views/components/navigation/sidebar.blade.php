{{-- resources/views/components/navigation/sidebar.blade.php --}}
@props(['links' => null])

@php
    $links = $links ?? config('navigation');
    
    // Definimos los iconos para cada ruta
    $icons = [
        'dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
        'actors.index' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />',
        'admin.users.index' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />',
        'characters.index' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />',
        'producers.index' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />',
        'plays.index' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />',
        'locations.index' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />',
        'events.index' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
    ];
@endphp

<div>
    {{-- ─── Menú móvil: invoca el componente genérico ─── --}}
    <x-navigation.mobile-menu
        :links="$links"
        event="toggle-sidebar"
        hiddenAt="sm"
        position="absolute top-16 left-4"
    />

    {{-- ─── Sidebar desktop fijo ─── --}}
    <aside class="hidden sm:flex flex-shrink-0 w-64 min-h-screen bg-gray-900 text-gray-200">
        <div class="flex flex-col w-full">
            {{-- Branding --}}
            <div class="h-16 flex items-center justify-center border-b border-gray-700">
                <span class="text-lg font-semibold">Marvel Plays</span>
            </div>

            {{-- Navegación --}}
            <nav class="py-4 px-3 space-y-1 overflow-y-auto max-h-screen">
                @foreach($links as $link)
                    @php
                        $show = Route::has($link['route'])
                             && (empty($link['roles'])
                                 || (auth()->check()
                                     && auth()->user()->getRoleNames()->intersect($link['roles'])->isNotEmpty()
                                    )
                                );
                        $isActive = request()->routeIs($link['route']);
                    @endphp

                    @if($show)
                        <div class="flex items-center w-full">
                            {{-- Icono --}}
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 text-gray-400" 
                                 xmlns="http://www.w3.org/2000/svg" 
                                 fill="none" 
                                 viewBox="0 0 24 24" 
                                 stroke="currentColor" 
                                 aria-hidden="true">
                                {!! $icons[$link['route']] ?? $icons['dashboard'] !!}
                            </svg>

                            <x-nav-link
                                :href="route($link['route'])"
                                :active="$isActive"
                                class="block w-full px-4 py-2 rounded-md
                                    {{ $isActive
                                        ? 'bg-gray-800 text-white'
                                        : 'text-gray-400 hover:text-white hover:bg-gray-800
                                           transition-transform duration-150 ease-out hover:scale-105' }}"
                            >
                                {{ $link['name'] }}
                            </x-nav-link>
                        </div>
                    @endif
                @endforeach
            </nav>
        </div>
    </aside>
</div>
