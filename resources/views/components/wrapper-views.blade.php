{{-- resources/views/components/wrapper-views.blade.php --}}
@props([''])

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div {{ $attributes->merge(['class' => 'bg-white shadow sm:rounded-lg overflow-hidden']) }}>
      
      {{-- ——— Zona de acciones (si existe) ——— --}}
      @isset($actions)
        <div class="px-6 py-4 border-b bg-gray-50 flex justify-end">
          {{ $actions }}
        </div>
      @endisset

      {{-- ——— Zona de contenido principal ——— --}}
      <div class="p-6">
        {{ $slot }}
      </div>

    </div>
  </div>
</div>
