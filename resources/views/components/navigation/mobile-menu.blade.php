@props(['links' => config('navigation')])

<div
    x-data="{ open: false }"
    @toggle-mobile-menu.window="open = !open"  {{-- ← mismo nombre --}}
    class="sm:hidden"
>
    {{-- Overlay --}}
    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 bg-black/40 z-40"
    ></div>

    {{-- Tarjeta flotante --}}
    <div
        x-show="open"
        x-transition.origin.top.left
        class="fixed top-16 left-4 w-56 bg-gray-900 text-gray-100 rounded-lg shadow-xl z-50"
    >
        <nav class="py-4 space-y-1">
            @foreach ($links as $link)
                @php
                    $routeExists = \Illuminate\Support\Facades\Route::has($link['route']);
                    $userCan = empty($link['roles']) || (
                        auth()->check() &&
                        auth()->user()->getRoleNames()->intersect($link['roles'])->isNotEmpty()
                    );
                @endphp

                @if ($routeExists && $userCan)
                    <a
                        href="{{ route($link['route']) }}"
                        class="block px-4 py-2 text-sm
                               hover:bg-gray-800 hover:text-white
                               {{ request()->routeIs($link['route']) ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                        @click="open = false"
                    >
                        {{ $link['name'] }}
                    </a>
                @endif
            @endforeach
        </nav>
    </div>
</div>
