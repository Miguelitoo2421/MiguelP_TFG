<div class="relative inline-block">
  {{-- Hueco negro siempre visible --}}
  <span class="absolute inset-0 bg-black rounded-md"></span>

  {{-- Botón adelantado por defecto, que entra al pasar el puntero --}}
  <button
    {{ $attributes->merge([
      'type' => 'submit',
      'class' => trim("
        relative inline-flex items-center px-4 py-2
        bg-blue-600 border border-transparent rounded-md
        font-semibold text-xs text-white uppercase tracking-widest

        transform transition-transform ease-in-out duration-150

        /* Estado inicial: fuera del hueco (hacia arriba e izquierda) */
        -translate-y-1 -translate-x-1

        /* Al hover: entra al hueco (posición original) */
        hover:translate-y-0 hover:translate-x-0
        hover:bg-blue-500

        /* Al active (clic): reforzar color */
        active:bg-blue-700

        /* Sin anillo de foco */
        focus:outline-none
      ")
    ]) }}
  >
    {{ $slot }}
  </button>
</div>
