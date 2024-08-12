<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
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
    <div class="flex justify-end pr-10 pt-5">
        <img class="w-44" src="{{ asset('img/Brand-LOKAsi.png')}}" alt="">
    </div>

    <div class="px-20 py-20">
        <h1 class="text-2xl font-semibold mb-3">
            <span class="text-black">Forgot your password?</span>
        </h1>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
    
        <form wire:submit="sendPasswordResetLink">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="w-full h-12 text-base rounded-md">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    
</div>
