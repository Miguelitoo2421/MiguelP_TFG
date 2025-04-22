<div class="relative inline-block group">
  {{-- Hueco negro idéntico al botón, oculto hasta el hover --}}
  <span
    class="absolute inset-0 bg-black rounded-md
           opacity-0 transition-opacity ease-in-out duration-150
           group-hover:opacity-100 pointer-events-none">
  </span>

  {{-- Botón real en azul --}}
  <button
    {{ $attributes->merge([
      'type' => 'submit',
      'class' => 'relative inline-flex items-center px-4 py-2
                  bg-blue-600 border border-transparent rounded-md
                  font-semibold text-xs text-white uppercase tracking-widest
                  transform transition-transform ease-in-out duration-150
                  group-hover:-translate-y-1 group-hover:-translate-x-1
                  hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700
                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2'
    ]) }}>
    {{ $slot }}
  </button>
</div>
