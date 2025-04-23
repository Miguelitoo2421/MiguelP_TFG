<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-wrapper-views>
        <div class="p-6 text-gray-900">
            {{ __("You're logged in!") }}
        </div>
    </x-wrapper-views>
</x-app-layout>
