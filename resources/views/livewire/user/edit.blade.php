<?php

use App\Models\User;
use App\Events\UserApproved;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;
    public string $role;

    public function mount(): void
    {
        $this->role = $this->user->roles->pluck('name')[0];
    }

    public function update(): void
    {
        $this->validate([
            'role' => ['required', 'string'],
        ]);

        $previousRole = $this->user->roles->pluck('name')[0];

        $this->user->removeRole($previousRole);

        $this->user->assignRole($this->role);

        $this->dispatch('user-updated');

        if ($previousRole === 'none' && $this->role !== 'none') {
            // dispatch UserApproved event
            UserApproved::dispatch($this->user);
        }
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
            <option value="coordinator" selected>Coordinator</option>
            <option value="contributor">Contributor</option>
            <option value="user">User</option>
        </select>
        <x-primary-button>{{ __('Save') }}</x-primary-button>
        <button wire:click.prevent="cancel">Cancel</button>    
    </form>
</div>
