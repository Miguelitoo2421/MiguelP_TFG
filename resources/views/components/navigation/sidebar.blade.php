{{-- resources/views/components/navigation/sidebar.blade.php --}}
@props(['links' => null])

@php
    $links = $links ?? config('navigation');
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
                    @endphp

                    @if($show)
                        <x-nav-link
                            :href="route($link['route'])"
                            :active="request()->routeIs($link['route'])"
                            class="block w-full px-4 py-2 rounded-md
                                   transition-transform duration-150 ease-out
                                   hover:scale-105
                                   {{ request()->routeIs($link['route'])
                                        ? 'bg-gray-800 text-white'
                                        : 'text-gray-400 hover:text-white hover:bg-gray-800' }}"
                        >
                            {{ $link['name'] }}
                        </x-nav-link>
                    @endif
                @endforeach
            </nav>
        </div>
    </aside>
</div>
