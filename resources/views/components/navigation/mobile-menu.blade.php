@props([
  'links',
  'event'     => 'toggle-mobile-menu',
  'hiddenAt'  => 'sm',
  'position' => 'absolute top-16 right-4',  
  'width'    => 'w-48',        
])

@php
  $visible = collect($links)->filter(function($link) {
      return Route::has($link['route'])
          && (empty($link['roles'])
              || (auth()->check()
                  && auth()->user()->getRoleNames()->intersect($link['roles'])->isNotEmpty()
                 )
             );
  });
@endphp

@if($visible->isNotEmpty())
  <div
    x-data="{ open: false }"
    x-on:{{ $event }}.window="open = !open"
    x-show="open"
    x-cloak
    class="{{ $hiddenAt }}:hidden fixed inset-0 z-60"
  >
    {{-- Overlay --}}
    <div @click="open = false" class="absolute inset-0 bg-black/40 z-60"></div>

    {{-- Panel flotante --}}
    <div
      x-show="open"
      x-transition.origin.top.right
      class="{{ $position }} {{ $width }}
             bg-gray-900 text-gray-100 rounded-lg shadow-xl
             z-70 overflow-hidden px-4 py-2"
    >
      <nav class="py-2 space-y-1">
        @foreach($visible as $link)
          @php
            $isActive = request()->routeIs($link['route']);
            // Clases compartidas con el sidebar:
            $base   = 'block w-full px-4 py-2 rounded-md border-b-2 border-transparent transition-transform duration-150 ease-out';
            $hover  = 'hover:scale-105 hover:border-blue-400 hover:bg-gray-800 hover:text-white';
            $active = 'border-blue-500 bg-gray-800 text-white';
            $inactive = 'text-gray-400';
            $classes = "$base $hover " . ($isActive ? $active : $inactive);
            $method = $link['method'] ?? 'get';
          @endphp

          @if($method === 'post')
            <form method="POST" action="{{ route($link['route']) }}">
              @csrf
              <button
                type="submit"
                class="{{ $classes }} text-left"
                @click="open = false"
              >
                {{ $link['name'] }}
              </button>
            </form>
          @else
            <a
              href="{{ route($link['route']) }}"
              class="{{ $classes }}"
              @click="open = false"
            >
              {{ $link['name'] }}
            </a>
          @endif
        @endforeach
      </nav>
    </div>
  </div>
@endif
