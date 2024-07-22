<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schools') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div>
                    <iframe src="https://www.google.com/maps/d/embed?mid=1uMV7hwMi2nfmbyUSJipgObe-4ipbneo&ehbc=2E312F" width="100%" height="640"></iframe>
                </div> 
            </div>
        </div>
    </div>

    
</x-app-layout>