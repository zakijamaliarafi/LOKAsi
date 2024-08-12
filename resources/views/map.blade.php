<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo leading-tight">
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