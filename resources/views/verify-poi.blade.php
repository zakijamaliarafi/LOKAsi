<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verify Report Point of Interest') }}
        </h2>
    </x-slot>

    <div class="flex justify-between my-10 mx-5">
        <livewire:verify-poi.info />
        <livewire:verify-poi.claim />
    </div>

    <div>
        <livewire:verify-poi.list />
    </div>
    
</x-app-layout>