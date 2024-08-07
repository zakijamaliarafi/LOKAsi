<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verify Report') }}
        </h2>
    </x-slot>

    <div class="flex justify-between my-10 mx-5">
        <livewire:verify-pa.info />
        <livewire:verify-pa.claim />
    </div>

    <div>
        <livewire:verify-pa.list />
    </div>
    
</x-app-layout>