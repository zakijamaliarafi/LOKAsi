<?php

use App\Models\User;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $users;

    public ?User $editing = null;

    public function mount(): void
    {
        $this->getUser();
    }

    public function getUser(): void
    {
        $this->users = User::role('none')
            ->where('id', '!=', auth()->id())
            ->latest()
            ->get();
            // dd($this->users);
    }

    public function edit(User $user): void
    {
        $this->editing = $user;

        $this->getUser();
    }

    #[On('user-updated')]
    #[On('user-update-cancelled')]
    public function disableEditForm(): void
    {
        $this->editing = null;
        $this->getUser();
    }
    
}; ?>

<div class="mt-5">
    <table class="text-left">
        <thead>
            <tr>
                <th class="w-24">No</th>
                <th class="w-48">User</th>
                <th class="w-64">Email</th>
                <th class="w-64">Address</th>
                <th class="w-64">Comunity</th>
                <th class="w-48">Role Request</th>
                <th class="w-36">Edit Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>    
                    <td class="">{{ $loop->iteration}}</td>
                    <td class="">{{ $user->name }}</td>
                    <td class="">{{ $user->email }}</td>
                    <td class="">{{ $user->address }}</td>
                    <td class="">{{ $user->comunity ?? '-' }}</td>
                    <td class="">{{ $user->role_request }}</td>
                    @if($user->is($editing))
                        <td class="">
                            <livewire:user.edit :user="$user" :key="$user->id" />
                        </td>
                    @else
                        <td class="">
                            <button wire:click="edit({{$user->id}})">edit role</button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>