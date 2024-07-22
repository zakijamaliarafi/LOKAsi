<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $address = '';
    public string $password = '';
    public string $role = 'none';

    public function store(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        $user->assignRole($this->role);

        $this->dispatch('user-added');
    }

    public function cancel(): void
    {
        $this->dispatch('user-add-canceled');
    }
}; ?>

<form wire:submit="store">
    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Full name')" />
        <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Address -->
    <div class="mt-4">
        <x-input-label for="address" :value="__('Address')" />
        <x-text-input wire:model="address" id="address" class="block mt-1 w-full" type="text" name="address" required autocomplete="address" />
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Role -->
    <div class="mt-4">
        <x-input-label for="role" :value="__('Role')" />
        <select wire:model="role" id="role" class="block mt-1 w-full" name="role" required>
            <option value="none">None</option>
            <option value="admin">Administrator</option>
            <option value="coordinator">Coordinator</option>
            <option value="contributor">Contributor</option>
            <option value="user">User</option>
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

    <x-primary-button class="ms-4">{{ __('Add') }}</x-primary-button>
    <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
</form>
