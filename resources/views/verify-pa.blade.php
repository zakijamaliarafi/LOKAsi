<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo leading-tight">
            {{ __('Verify Report Point Addressing') }}
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