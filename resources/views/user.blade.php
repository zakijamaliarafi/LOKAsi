<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo leading-tight">
            {{ __('Manage User') }}
        </h2>
    </x-slot>

    <livewire:user.list />

</x-app-layout>