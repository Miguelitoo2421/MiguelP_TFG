<div {{ $attributes->merge(['class' => 'relative inline-block']) }}>
  {{-- Hueco negro siempre visible --}}
  <span class="absolute inset-0 bg-black rounded-md"></span>

  {{-- Botón rojo que entra al hover y sale al quitar el puntero --}}
  <button
    type="submit"
    class="relative inline-flex items-center px-4 py-2
           bg-red-600 border border-transparent rounded-md
           font-semibold text-xs text-white uppercase tracking-widest

           transform transition-transform ease-in-out duration-150

           /* Estado inicial: adelantado fuera del hueco */
           -translate-y-1 -translate-x-1

           /* Al hover: vuelve a posición original (entra en el hueco) */
           hover:translate-y-0 hover:translate-x-0
           hover:bg-red-500

           /* Sin anillo de foco */
           focus:outline-none focus:ring-0
    ">
    {{ $slot }}
  </button>
</div>
