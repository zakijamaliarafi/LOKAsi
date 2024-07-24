<?php

use App\Models\User;
use App\Events\UserSuspended;
use App\Events\UserActivated; 
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
        $this->users = User::withoutRole('admin')
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

    public function suspendUser(User $user): void
    {
        if ($user->suspend) {
            $user->update([
                'suspend' => false,
            ]);

            // dispatch UserActivated event
            UserActivated::dispatch($user);
        } else {
            $user->update([
                'suspend' => true,
            ]);

            // dispatch UserSuspended event
            UserSuspended::dispatch($user);
        }

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
                    <table class="text-left">
                        <thead>
                            <tr>
                                <th class="py-1 w-2/12">User</th>
                                <th class="py-1 w-1/12">Role</th>
                                <th class="py-1 w-2/12">Email</th>
                                <th class="py-1 w-2/12">Address</th>
                                <th class="py-1 w-1/12">Edit Role</th>
                                <th class="py-1 w-1/12">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    @if($user->suspend)
                                        <td>{{ $user->name }}</td>
                                        <td>-</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>-</td>
                                        <td>
                                            <button wire:click="suspendUser({{$user->id}})">activate</button>
                                        </td>
                                    @else
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->roles->pluck('name')->join(', ')}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        @if($user->is($editing))
                                            <td>
                                                <livewire:user.edit :user="$user" :key="$user->id" />
                                            </td>
                                        @else
                                            <td>
                                                <button wire:click="edit({{$user->id}})">edit role</button>
                                            </td>
                                        @endif
                                        <td>
                                            <button wire:click="suspendUser({{$user->id}})">suspend</button>
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

</div>
