{{-- resources/views/layouts/navigation.blade.php --}}
@php
  $primaryLinks = config('navigation');
  $userLinks    = [
    ['name'=>'Profile','route'=>'profile.edit','method'=>'get'],
    ['name'=>'Log Out','route'=>'logout','method'=>'post'],
  ];
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
    {{-- Logo --}}
    <div class="flex-shrink-0">
      <a href="{{ route('dashboard') }}">
        <x-application-logo class="" />
      </a>
    </div>

    {{-- Usuario (desktop ≥sm) --}}
    <div class="hidden sm:flex sm:items-center sm:ml-6" x-data>
      <button @click="$dispatch('toggle-user-menu')" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
        {{ Auth::user()->name }}
        <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
          <path clip-rule="evenodd" fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
        </svg>
      </button>

      <x-navigation.mobile-menu
        x-cloak
        :links="$userLinks"
        event="toggle-user-menu"
        hiddenAt=""
        container="absolute top-12 right-4 w-48"
      />
    </div>

    {{-- Hamburger (mobile <sm) --}}
    <div class="sm:hidden" x-data>
      <button @click="$dispatch('toggle-mobile-menu')" class="inline-flex items-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </div>

  {{-- Panel flotante (mobile) --}}
  <x-navigation.mobile-menu
    :links="$userLinks"
    event="toggle-mobile-menu"
    hiddenAt="sm"
    container="fixed top-16 left-4 w-64"
  />
</nav>
