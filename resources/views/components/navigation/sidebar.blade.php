{{-- resources/views/components/navigation/sidebar.blade.php --}}
@props(['links' => null])

@php  $links = $links ?? config('navigation');  @endphp

<div
    x-data="{ open: false }"
    @toggle-sidebar.window="open = !open"
    class="flex"
>
    {{-- #### Overlay (móvil) #### --}}
    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 bg-gray-900/60 z-40 sm:hidden"
    ></div>

    {{-- #### Panel lateral #### --}}
    <aside
        class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-gray-200 z-50
               transform transition-transform duration-200 ease-out
               -translate-x-full
               sm:translate-x-0 sm:static sm:flex-shrink-0 sm:min-h-screen"
        :class="{'translate-x-0': open}"
    >
        {{-- Branding (solo desktop) --}}
        <div class="hidden sm:flex h-16 items-center justify-center border-b border-gray-700">
            <span class="text-lg font-semibold">Marvel Plays</span>
        </div>

        {{-- ===== Navegación ===== --}}
        <nav class="py-4 px-3 space-y-1 overflow-y-auto max-h-screen">
            @foreach ($links as $link)
                @php
                    $routeExists = \Illuminate\Support\Facades\Route::has($link['route']);
                    $userCan     = empty($link['roles']) || (
                        auth()->check() &&
                        auth()->user()->getRoleNames()->intersect($link['roles'])->isNotEmpty()
                    );
                @endphp

                @if ($routeExists && $userCan)
                <x-nav-link
                    :href="route($link['route'])"
                    :active="request()->routeIs($link['route'])"
                    class="block w-full px-4 py-2 rounded-md
                          transition-transform duration-150 ease-out      {{-- ← transición suave --}}
                          hover:scale-105                                 {{-- ← 5 % más grande al pasar el ratón --}}
                          {{ request()->routeIs($link['route'])
                                ? 'bg-gray-800 text-white'
                                : 'text-gray-400 hover:text-white
                                hover:bg-gray-800' }}"
                    @click="open = false"
                >
                    {{ $link['name'] }}
                </x-nav-link>
                @endif
            @endforeach
        </nav>
    </aside>
</div>
