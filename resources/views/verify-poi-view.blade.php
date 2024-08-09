<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo leading-tight">
            {{ __('Verify Report') }}
        </h2>
    </x-slot>
    
    <livewire:verify-poi.view />
</x-app-layout>