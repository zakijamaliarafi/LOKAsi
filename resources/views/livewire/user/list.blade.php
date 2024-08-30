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

    public $list = true;
    public $creating = false;
    public $approval = false;

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
        $this->list = false;
    }

    #[On('user-add-canceled')]
    #[On('user-added')]
    public function disableAddForm(): void
    {
        $this->creating = false;
        $this->list = true;
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

    public function approve(): void
    {
        $this->list = false;
        $this->approval = true;
        
    }

    public function back(): void
    {
        $this->approval = false;
        $this->list = true;
    }
}; ?>

<div>
    @if($list)
    <div class="pt-4 flex justify-end gap-x-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button wire:click="create">{{ __('Add User')}}</x-primary-button>
        <x-primary-button wire:click="approve">{{ __('Approve User')}}</x-primary-button>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="verflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-0 text-gray-900">
                    <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                        <thead>
                            <tr class="text-indigo font-semibold bg-flash-white">
                                <th class="py-1 px-2 pl-5">No</th>
                                <th class="py-1 px-2">User</th>
                                <th class="py-1 px-2">Role</th>
                                <th class="py-1 px-2">Email</th>
                                <th class="py-1 px-2">Address</th>
                                <th class="py-1 px-2">Edit Role</th>
                                <th class="py-1 px-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="bg-white shadow-md">    
                                        <td class="text-indigo py-1 px-2 pl-5">{{ $loop->iteration}}</td>
                                    @if($user->suspend)
                                        <td class="text-indigo py-1 px-2">{{ $user->name }}</td>
                                        <td class="text-indigo py-1 px-2">-</td>
                                        <td class="text-indigo py-1 px-2">{{ $user->email }}</td>
                                        <td class="text-indigo py-1 px-2 max-w-72">{{ $user->address }}</td>
                                        <td class="text-indigo py-1 px-2">-</td>
                                        <td class="text-green-700 py-1 px-2 text-center">
                                            <button wire:click="suspendUser({{$user->id}})">activate</button>
                                        </td>
                                    @else
                                        <td class="text-indigo py-1 px-2">{{ $user->name }}</td>
                                        <td class="text-indigo py-1 px-2">
                                            {{ $user->roles->pluck('name')->map(function($role) {
                                                return $role === 'user' ? 'viewer' : $role;
                                            })->join(', ') }}
                                        </td>
                                        <td class="text-indigo py-1 px-2">{{ $user->email }}</td>
                                        <td class="text-indigo py-1 px-2 max-w-72">{{ $user->address }}</td>
                                        @if($user->is($editing))
                                            <td >
                                                <livewire:user.edit :user="$user" :key="$user->id" />
                                            </td>
                                        @else
                                            <td class="text-indigo py-1 px-2">
                                                <button wire:click="edit({{$user->id}})">edit role</button>
                                            </td>
                                        @endif
                                        <td class="text-red-700 py-1 px-2 text-center">
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
    @endif

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

    @if($approval)
        <button wire:click="back" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</button>
        <livewire:user.approve />      
    @endif

</div>
