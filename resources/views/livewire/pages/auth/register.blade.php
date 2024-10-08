<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $address = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role_request = 'viewer';
    public ?string $comunity = null;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'numeric'],
            'address' => ['required', 'string', 'max:255'],
            'role_request' => ['required'],
            'comunity' => [Rule::requiredIf($this->role_request === 'contributor')],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        $user->assignRole('none');

        Auth::login($user);

        // redirect to email verification
        $this->redirect(route('verification.notice'), navigate: true);
    }
}; ?>

<x-slot:image>
    <div class="bg-pastel-blue h-full relative">
        <div class="h-full flex justify-center items-center">
            <img class="w-full" src="{{ asset('img/guest-marker.png')}}" alt="">
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
            <span class="text-black">Get Started</span>
        </h1>
        <p class="text-lg font-medium text-dim-gray mb-8">
            Create your account first
        </p>
        <form wire:submit="register">
            <!-- Name -->
            <div>
                <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="name" :value="__('Full name')" />
                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Address -->
            <div class="mt-4">
                <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="address" :value="__('Address')" />
                <x-text-input wire:model="address" id="address" class="block mt-1 w-full" type="text" name="address" required autocomplete="address" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Phone Number -->
            <div class="mt-4">
                <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="phone" :value="__('Phone number')" />
                <x-text-input wire:model="phone" id="phone" class="block mt-1 w-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" type="tel" pattern="\d{10,13}" required autocomplete="phone" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="password" :value="__('Password')" />
    
                <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="password_confirmation" :value="__('Retype password')" />
    
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div x-data="{ show:false }">
                <div class="mt-4">
                    <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="role_request" :value="__('Sign up as')" />
                    <select id="role_request" wire:model="role_request" x-on:change="show = $event.target.value === 'contributor'" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="viewer">Viewer</option>
                        <option value="contributor">Contributor</option>
                    </select>
                    <x-input-error :messages="$errors->get('role_request')" class="mt-2" />
                </div>
    
                <div class="mt-4" x-show="show">
                    <x-input-label class="text-lg font-medium text-dim-gray mb-2" for="comunity" :value="__('comunity')" />
                    <select id="comunity" wire:model="comunity" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">none</option>
                        <option value="Antasena Map Comunity">Antasena Map Comunity</option>
                        <option value="Antasena Map Universe">Antasena Map Univ</option>
                        <option value="Antasena Map Study Club">Antasena Map Study Club</option>                        
                    </select>
                    <x-input-error :messages="$errors->get('comunity')" class="mt-2" />
                </div>
            </div>
    
            <div class="mt-8">
                <x-primary-button class="w-full h-16 text-xl rounded-md">
                    {{ __('Sign Up') }}
                </x-primary-button>
            </div>
    
            <div class="flex items-center justify-center mt-6 mr-2">
                <p class="text-sm text-dim-gray">
                    Have an account? 
                    <a class="text-light-blue hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                        {{ __('Login') }}
                    </a>
                </p>
                
            </div>
        </form>
    </div>

</div>
