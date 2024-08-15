<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo leading-tight">
            {{ __('Manage Report PA') }}
        </h2>
    </x-slot>

    <livewire:report-pa.list />
</x-app-layout>