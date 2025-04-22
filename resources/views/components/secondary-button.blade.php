<div class="relative inline-block group">
    {{-- Hueco negro idéntico al botón, oculto hasta el hover --}}
    <span
      class="absolute inset-0 bg-black rounded-md opacity-0
             transition-opacity ease-in-out duration-150
             group-hover:opacity-100 pointer-events-none">
    </span>
  
    {{-- Botón real --}}
    <button
      {{ $attributes->merge([
        'type' => 'button',
        'class' => 'relative inline-flex items-center px-4 py-2
                    bg-white border border-gray-300 rounded-md
                    font-semibold text-xs text-gray-700 uppercase tracking-widest
                    shadow-sm
                    transform transition-transform ease-in-out duration-150
                    group-hover:-translate-y-1 group-hover:-translate-x-1
                    hover:bg-gray-50
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                    disabled:opacity-25'
      ]) }}>
      {{ $slot }}
    </button>
  </div>
  