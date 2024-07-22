<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome!") }}
                </div>
            </div>
        </div>
    </div>

    {{-- <div>
        <iframe src="https://www.google.com/maps/d/embed?mid=1uMV7hwMi2nfmbyUSJipgObe-4ipbneo&ehbc=2E312F" width="640" height="480"></iframe>
    </div> --}}
</x-app-layout>
