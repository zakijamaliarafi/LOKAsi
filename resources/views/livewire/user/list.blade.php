<?php

use App\Models\User;
use App\Events\UserApproved; 
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;

new class extends Component {
    public Collection $users;

    public $creating = false;

    public ?User $editing = null;

    public function mount(): void
    {
        $this->getUser();
    }

    public function getUser(): void
    {
        $this->users = User::with('roles')
            ->where('deleted', false)
            ->where('id', '!=', auth()->id())
            ->latest()
            ->get();
    }

    public function create(): void
    {
        $this->creating = true;
    }

    #[On('user-add-canceled')]
    #[On('user-added')]
    public function disableAddForm(): void
    {
        $this->creating = false;
        $this->getUser();
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

    // public function addUserRole(User $user): void
    // {
    //     $user->removeRole('none');
    //     $user->assignRole('user');

    //     $this->getUser();

    //     // dispatch UserApproved event
    //     UserApproved::dispatch($user);
    // }

    public function deleteUser(User $user): void
    {
        $user->update([
            'deleted' => true,
        ]);

        $this->getUser();
    }

}; ?>

<div>

    <div class="pt-4 flex justify-end max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button wire:click="create">{{ __('Add User')}}</x-primary-button>    
    </div>

    @if($creating)
    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:user.create />
                </div>
            </div>
        </div>
    </div>    
    @endif

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table>
                        <thead>
                            <tr>
                                <th class="py-1 px-2 w-2/12">User</th>
                                <th class="py-1 px-2 w-2/12">Role</th>
                                <th class="py-1 px-2 w-2/12">Email</th>
                                <th class="py-1 px-2 w-2/12">Address</th>
                                <th class="py-1 px-2 w-1/12">Edit</th>
                                <th class="py-1 px-2 w-1/12">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->roles->pluck('name')->join(', ')}}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->address }}</td>
                                    @if($user->is($editing))
                                    <td>
                                        <livewire:user.edit :user="$user" :key="$user->id" />
                                    </td>
                                    @else
                                    <td class="text-center">
                                        <button wire:click="edit({{$user->id}})">edit role</button>
                                    </td>
                                    @endif
                                    <td class="text-center">
                                        <button wire:click="deleteUser({{$user->id}})">delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
