<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo leading-tight">
            {{ __('Manage Report POI') }}
        </h2>
    </x-slot>

    <livewire:report-poi.list />
</x-app-layout>