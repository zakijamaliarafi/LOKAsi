<?php

use App\Livewire\Actions\Logout;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.doc')] class extends Component
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


<div class="min-h-screen bg-indigo flex flex-row relative">
    <div class="w-7/12">
        <div class="flex items-center gap-x-5 pl-20 pt-5">
            <img class="h-12" src="{{ asset('img/Logo-LOKAsi.png')}}" alt="">
            <p class="text-lg text-white">Explore new location with us!</p>
        </div>
        <div class="pl-14 pr-28 pt-20">
            <div class="flex justify-start">
                <img src="{{ asset('img/quotation-start.svg')}}" alt="">
            </div>
            <div class="flex justify-center">
                <div class="text-3xl text-white font-bold leading-10">
                    <p>Thank you for registering</p>
                    <p>your account !</p>
                </div>
            </div>
            <div class="flex justify-end">
                <img src="{{ asset('img/quotation-end.svg')}}" alt="">
            </div>
        </div>
        <div class="bg-pastel-blue bg-opacity-50 w-96 ml-36 py-8 px-6 rounded-xl mt-5">
            <p class="text-lg text-white font-normal">We will contact you via email after admin received your registration.</p>
        </div>
    </div>

    <div class="w-5/12">
        <div class="h-[90%] w-5/6 bg-flash-white rounded-b-xl pt-5 px-5">
            <div class="flex justify-between items-center">
                <div class="h-2 w-48 bg-indigo"></div>
                <div wire:click="logout">
                    <x-primary-button class="text-xs rounded-full">Back to Login page</x-primary-button>
                </div>
            </div>
            <div class="flex justify-center mt-16">
                <img class="w-72" src="{{ asset('img/waiting-logo.png')}}" alt="">
            </div>
            <div class="flex justify-center mt-16">
                <p class="text-3xl text-indigo font-normal">Please wait</p>
            </div>
            <div class="flex justify-center mt-2">
                <div class="h-2 w-[22rem] bg-indigo rounded-md"></div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-2 left-2">
        <p class="text-sm text-white">Copyright © 2024 PT Antasena Terra Solution. All rights reserved.</p>
    </div>
</div>
    
