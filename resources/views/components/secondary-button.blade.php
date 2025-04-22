<div class="relative inline-block">
  {{-- Hueco negro siempre visible --}}
  <span class="absolute inset-0 bg-black rounded-md"></span>

  {{-- Botón blanco con efecto de “entrar” al hover --}}
  <button
    {{ $attributes->merge([
      'type' => 'button',
      'class' => trim("
        relative inline-flex items-center px-4 py-2
        bg-white border border-gray-300 rounded-md
        font-semibold text-xs text-gray-700 uppercase tracking-widest
        shadow-sm

        transform transition-transform ease-in-out duration-150

        /* Estado inicial: adelantado fuera del hueco */
        -translate-y-1 -translate-x-1

        /* Al hover: vuelve a posición original (entra en el hueco) */
        hover:translate-y-0 hover:translate-x-0
        hover:bg-gray-50

        /* Quita cualquier anillo de foco */
        focus:outline-none focus:ring-0
      ")
    ]) }}
  >
    {{ $slot }}
  </button>
</div>
