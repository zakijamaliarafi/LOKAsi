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

<div class="pt-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-0 text-gray-900">
                <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                    <thead>
                        <tr class="text-indigo font-semibold bg-flash-white">
                            <th class="py-1 px-2 pl-5">No</th>
                            <th class="py-1 px-2">User</th>
                            <th class="py-1 px-2">Email</th>
                            <th class="py-1 px-2 max-w-72">Address</th>
                            <th class="py-1 px-2">Comunity</th>
                            <th class="py-1 px-2">Role Request</th>
                            <th class="py-1 px-2">Edit Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>    
                                <td class="py-1 px-2 pl-5">{{ $loop->iteration}}</td>
                                <td class="py-1 px-2">{{ $user->name }}</td>
                                <td class="py-1 px-2">{{ $user->email }}</td>
                                <td class="py-1 px-2 max-w-72">{{ $user->address }}</td>
                                <td class="py-1 px-2">{{ $user->comunity ?? '-' }}</td>
                                <td class="py-1 px-2">{{ $user->role_request }}</td>
                                @if($user->is($editing))
                                    <td>
                                        <livewire:user.edit :user="$user" :key="$user->id" />
                                    </td>
                                @else
                                    <td class="py-1 px-2">
                                        <button wire:click="edit({{$user->id}})">edit role</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
            </div>
        </div>
    </div>
</div>