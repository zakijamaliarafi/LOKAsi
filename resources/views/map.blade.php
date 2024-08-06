<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Map') }}
        </h2>
    </x-slot>

    <livewire:map.view />

    <script>
        function category_selected(category){
            Livewire.dispatch('category-selected', category);
        }
    </script>

</x-app-layout>