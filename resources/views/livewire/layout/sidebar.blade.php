<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="w-48 min-h-screen bg-flash-white relative">
    <div class="flex justify-center mt-5 mb-10">
        <img class="w-32" src="{{ asset('img/Brand-LOKAsi.png')}}" alt="">
    </div>

    <nav x-data="{ open: false }">
        <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="my-5" wire:navigate>
            <div class="flex pl-4 items-center gap-2">
                <img class="h-6" src="{{ asset('img/home-icon.svg')}}" alt="">
                {{__('Home')}}
            </div>
        </x-nav-link>

        @role('admin')
        <x-nav-link :href="route('user.manage')" :active="request()->routeIs('user.manage')" class="my-5" wire:navigate>
            <div class="flex justify-center items-center gap-2">
                <img class="h-8" src="{{ asset('img/manage-user-icon.svg')}}" alt="">
                {{__('Manage User')}}
            </div>
        </x-nav-link>
        @endrole

        @role('coordinator')
        <div class="my-5">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center py-2 text-lg leading-4 font-medium rounded-md text-black  hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <img class="h-8 mr-2" src="{{ asset('img/verify-icon.svg')}}" alt="">
                        <div x-data="{{ json_encode(['name' => 'Manage Report']) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('report.poi')" wire:navigate>
                        {{ __('POI Report') }}
                    </x-dropdown-link>

                    <x-dropdown-link :href="route('report.pa')" wire:navigate>
                        {{ __('Point Addressing Report') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <x-nav-link :href="route('project.manage')" :active="request()->routeIs('project.manage')" class="my-5" wire:navigate>
            <div class="flex justify-center items-center">
                <img class="h-8" src="{{ asset('img/project-icon.svg')}}" alt="">
                {{ __('Manage Project') }}
            </div>
        </x-nav-link>
        @endrole

        @role('contributor')
        <x-nav-link :href="route('report')" :active="request()->routeIs('report')" class="my-5" wire:navigate>
            <div class="flex pl-4 items-center gap-2">
                <img class="h-8" src="{{ asset('img/report-icon.svg')}}" alt="">
                {{__('Report')}}
            </div>
        </x-nav-link>
        @endrole

        @role('curator')
        <div class="my-5">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center pl-5 py-2 text-lg leading-4 font-medium rounded-md text-black  hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <img class="h-8 mr-2" src="{{ asset('img/verify-icon.svg')}}" alt="">
                        <div x-data="{{ json_encode(['name' => 'Verify Report']) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('verify.poi')" wire:navigate>
                        {{ __('Verify POI') }}
                    </x-dropdown-link>

                    <x-dropdown-link :href="route('verify.pa')" wire:navigate>
                        {{ __('Verify Point Addressing') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>
        @endrole

        <div class="my-5">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center pl-5 py-2 text-xl leading-4 font-medium rounded-md text-black  hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <img class="h-8 mr-2" src="{{ asset('img/category-icon.svg')}}" alt="">
                        <div x-data="{{ json_encode(['name' => 'Category']) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    @if(request()->routeIs('map'))
                    <button onclick="category_selected('penginapan');" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Hostelry</button>
                    <button onclick="category_selected('kuliner');" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Culinary</button>
                    <button onclick="category_selected('education');" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Schools</button>
                    <button onclick="category_selected('office');" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Office</button>
                    <button onclick="category_selected('tempatibadah');" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Place of worship</button>
                    @else
                    <a href="/map?category=penginapan" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Hostelry</a>
                    <a href="/map?category=kuliner" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Culinary</a>
                    <a href="/map?category=education" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Schools</a>
                    <a href="/map?category=office" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Office</a>
                    <a href="/map?category=tempatibadah" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Place of worship</a>
                    @endif
                    
                </x-slot>
            </x-dropdown>
        </div>

        <div class="flex pl-4 items-center gap-2 absolute bottom-4 left-2">
            <img src="{{ asset('img/logout-icon.svg')}}" alt="">
            <button wire:click="logout" class="w-full text-start text-xl text-black">
                    {{ __('Log Out') }}
            </button>
        </div>

    </nav>
    
</div>