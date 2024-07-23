<?php

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;

    public string $role = 'none';

    public function update(): void
    {
        $this->validate([
            'role' => ['required', 'string'],
        ]);

        $previousRole = $this->user->roles->pluck('name')[0];
        
        $this->user->removeRole($previousRole);

        $this->user->assignRole($this->role);

        $this->dispatch('user-updated');
    }

    public function cancel(): void
    {
        $this->dispatch('user-update-cancelled');
    }

}; ?>

<div>
    <form wire:submit="update">
        <select wire:model="role" id="role" name="role" required>
            <option value="none">None</option>
            <option value="admin">Administrator</option>
            <option value="coordinator">Coordinator</option>
            <option value="contributor">Contributor</option>
            <option value="user">User</option>
        </select>
        <x-primary-button>{{ __('Save') }}</x-primary-button>
        <button wire:click.prevent="cancel">Cancel</button>    
    </form>
</div>
