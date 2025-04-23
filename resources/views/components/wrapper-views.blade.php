@props(['']) 

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div {{ $attributes->merge(['class' => 'bg-white shadow sm:rounded-lg overflow-hidden']) }}>
      {{ $slot }}
    </div>
  </div>
</div>
