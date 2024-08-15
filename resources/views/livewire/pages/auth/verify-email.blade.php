<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

}; ?>

<x-slot:image>
    <div class="bg-pastel-blue h-full relative">
        <div class="h-full flex justify-center items-center">
            <img class="w-[28rem] h-[28rem]" src="{{ asset('img/guest-mail.png')}}" alt="">
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
            <span class="text-black">Thanks for signing up!</span>
        </h1>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
    
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
    
        <div class="mt-4">
            <x-primary-button wire:click="sendVerification" class="w-full h-12 text-base rounded-md">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </div>
    </div>
</div>
