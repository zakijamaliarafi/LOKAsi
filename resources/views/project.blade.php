<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo leading-tight">
            {{ __('Manage Project') }}
        </h2>
    </x-slot>

    <livewire:project.list />

</x-app-layout>