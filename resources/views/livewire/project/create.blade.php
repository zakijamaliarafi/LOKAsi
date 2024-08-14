<?php

use App\Models\Project;
use App\Models\ProjectType;
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection;

new class extends Component {
    public Collection $types;

    public string $project_name = '';
    public string $client = '';
    public string $project_area = '';
    public string $project_volume = '';
    public string $project_period = '';
    public string $project_type_id = '';

    public function mount(): void
    {
        $this->types = ProjectType::all();
    }

    public function store(): void
    {
        $validated = $this->validate([
            'project_name' => ['required', 'string', 'max:255'],
            'client' => ['required', 'string', 'max:255'],
            'project_area' => ['required', 'string', 'max:255'],
            'project_volume' => ['required', 'string', 'max:255'],
            'project_period' => ['required', 'string', 'max:255'],
            'project_type_id' => ['required', 'string'],
        ]);

        Project::create($validated);

        $this->dispatch('project-added');
    }

    public function cancel(): void
    {
        $this->dispatch('project-add-canceled');
    }
}; ?>

<div>
    <form wire:submit="store">
        <!-- Project Name -->
        <div>
            <x-input-label for="name" :value="__('Project Name')" />
            <x-text-input wire:model="project_name" id="name" class="block mt-1 w-full" type="text" required autofocus />
            <x-input-error :messages="$errors->get('project_name')" class="mt-2" />
        </div>
    
        <!-- Client -->
        <div class="mt-4">
            <x-input-label for="client" :value="__('Client')" />
            <x-text-input wire:model="client" id="client" class="block mt-1 w-full" type="text" required />
            <x-input-error :messages="$errors->get('client')" class="mt-2" />
        </div>
    
        <!-- Project Area -->
        <div class="mt-4">
            <x-input-label for="area" :value="__('Project Area')" />
            <x-text-input wire:model="project_area" id="area" class="block mt-1 w-full" type="text" required />
            <x-input-error :messages="$errors->get('project_area')" class="mt-2" />
        </div>

        <!-- Project Volume -->
        <div class="mt-4">
            <x-input-label for="vol" :value="__('Project Volume')" />
            <x-text-input wire:model="project_volume" id="vol" class="block mt-1 w-full" type="text" required />
            <x-input-error :messages="$errors->get('project_volume')" class="mt-2" />
        </div>

        <!-- Project Period -->
        <div class="mt-4">
            <x-input-label for="period" :value="__('Project Period')" />
            <x-text-input wire:model="project_period" id="period" class="block mt-1 w-full" type="text" required />
            <x-input-error :messages="$errors->get('project_period')" class="mt-2" />
        </div>
    
        <!-- Project Type -->
        <div class="mt-4">
            <x-input-label for="type" :value="__('Project Type')" />
            <select wire:model="project_type_id" id="type" class="block mt-1 w-full" required>
                <option value="">none</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->project_type }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
    
        <x-primary-button class="ms-4">{{ __('Add') }}</x-primary-button>
        <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
    </form>
</div>
