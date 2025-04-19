@php
    // Navegación principal
    $primaryLinks = config('navigation');

    // Sólo Profile  y Log Out para el usuario
    $userLinks = [
        ['name' => 'Profile',  'route' => 'profile.edit', 'roles' => [], 'method'=>'get'],
        ['name' => 'Log Out',  'route' => 'logout',       'roles' => [], 'method'=>'post'],
    ];
@endphp

<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>
            <div class="flex items-center space-x-4">
                {{-- Usuario desktop ≥sm --}}
                <div class="hidden sm:block" x-data>
                    <button
                        @click="$dispatch('toggle-user-menu')"
                        class="inline-flex items-center px-3 py-2
                               border border-transparent text-sm font-medium
                               rounded-md text-gray-500 bg-white hover:text-gray-700
                               focus:outline-none transition"
                    >
                        {{ Auth::user()->name }}
                        <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293
                                     a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4
                                     a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>

                    {{-- Panel flotante usuario --}}
                    <x-navigation.mobile-menu
                        :links="$userLinks"
                        event="toggle-user-menu"
                        hiddenAt=""                 {{-- sin ocultar en desktop --}}
                    />
                </div>

                {{-- Hamburguesa mobile <sm --}}
                <div class="sm:hidden" x-data>
                    <button
                        @click="$dispatch('toggle-hamburger')"
                        class="inline-flex items-center justify-center p-2
                               rounded-md text-gray-400 hover:text-gray-500
                               hover:bg-gray-100 focus:outline-none transition"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel flotante principal (hamburguesa) --}}
    <x-navigation.mobile-menu
        :links="$userLinks"
        event="toggle-hamburger"
        hiddenAt="sm"
    />
</nav>
