<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-2xl font-semibold text-gray-900">
                    <p>Welcome to <span class="text-3xl text-indigo">LOKA</span><span class="text-[#FF0000]">SI</span>, let’s explore</p> 
                    <p>more location with <span class="text-3xl text-indigo">LOKA</span><span class="text-[#FF0000]">SI</span></p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
