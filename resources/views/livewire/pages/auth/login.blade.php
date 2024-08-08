<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<x-slot:image>
    <div class="bg-pastel-blue h-full relative">
        <div class="h-full flex justify-center items-center">
            <img class="w-[28rem] h-[28rem]" src="{{ asset('img/guest-map.png')}}" alt="">
        </div>
        <div class="absolute bottom-2 left-2">
            <p class="text-sm text-white">Copyright © 2024 PT Antasena Terra Solution. All rights reserved.</p>
        </div>
    </div>
</x-slot:image>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex justify-end pr-10 pt-5">
        <img class="w-44" src="{{ asset('img/Brand-LOKAsi.png')}}" alt="">
    </div>

    <div class="px-20 py-20">
        <h1 class="text-2xl font-semibold mb-3">
            <span class="text-black">Welcome to</span> <span class="text-indigo">LOKA</span><span class="text-[#FF0000]">si</span>
        </h1>
        <p class="text-lg font-medium text-dim-gray mb-8">
            Please Login first
        </p>
    
        <form wire:submit="login">
            <!-- Email Address -->
            <div>
                <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="password" :value="__('Password')" />
    
                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
    
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>
    
            <div class="flex justify-end mt-2">
                @if (Route::has('password.request'))
                    <a class="text-xs text-light-blue hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            
    
            <div class="mt-8">
                <x-primary-button class="w-full h-12 text-xl rounded-md">
                    {{ __('Sign in') }}
                </x-primary-button>
            </div>
    
            <!-- Register link -->
            <div class="flex items-center justify-center mt-6 mr-2">
                <p class="text-sm text-dim-gray">
                    Dont have an account? 
                    <a class="text-light-blue hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}" wire:navigate>
                        {{ __('Register now') }}
                    </a>
                </p>
                
            </div>
        </form>
    </div>

</div>
