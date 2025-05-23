<button
  type="button"
  x-data
  {{ $attributes->merge([
      
      'class' => 'sm:hidden
                  bg-gray-900 text-gray-100 px-3 py-2
                  rounded-lg font-semibold tracking-wide
                  shadow-lg transform transition duration-200
                  ease-in-out hover:scale-110 active:scale-95'
  ]) }}
  @click="$dispatch('toggle-sidebar')"
>
  {{ $slot }}
</button>