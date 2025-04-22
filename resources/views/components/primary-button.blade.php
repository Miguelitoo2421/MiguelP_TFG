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
        'type' => 'submit',
        'class' => 'relative inline-flex items-center px-4 py-2
                    bg-gray-800 border border-transparent rounded-md
                    font-semibold text-xs text-white uppercase tracking-widest
                    transform transition-transform ease-in-out duration-150
                    group-hover:-translate-y-1 group-hover:-translate-x-1
                    hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2'
      ]) }}>
      {{ $slot }}
    </button>
  </div>
  