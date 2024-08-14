<?php

use App\Models\Project;
use Livewire\Volt\Component;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Collection;

new class extends Component {
    public Collection $projects;

    public $creating = false;

    public ?Project $detail = null;

    public ?Project $editing = null;

    public function mount(): void
    {
        $this->getProjects();
    }

    public function getProjects(): void
    {
        $this->projects = Project::with('type')->latest()->get();
    }

    public function create(): void
    {
        $this->creating = true;
    }

    #[On('project-add-canceled')]
    #[On('project-added')]
    public function disableAddForm(): void
    {
        $this->creating = false;
        $this->getProjects();
    }

    public function detailProject(string $projectId): void
    {
        $this->detail = Project::findOrFail($projectId);
    }

    #[On('project-detail-canceled')]
    public function hideDetail(): void
    {
        $this->detail = null;
        $this->getProjects();
    }

    public function editProject(string $projectId): void
    {
        $this->editing = Project::findOrFail($projectId);
    }

    #[On('project-edit-canceled')]
    #[On('project-edited')]
    public function disableEditForm(): void
    {
        $this->editing = null;
        $this->getProjects();
    }

    public function deleteProject(Project $project): void
    {
        $project->delete();

        $this->getProjects();
    } 
}; ?>

<div>
    <div class="pt-4 flex justify-end max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button wire:click="create">{{ __('Create Project')}}</x-primary-button>    
    </div>

    @if($creating)
    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:project.create />
                </div>
            </div>
        </div>
    </div>    
    @endif

    @if($detail)
    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:project.show :project="$detail" />
                </div>
            </div>
        </div>
    </div>    
    @endif

    @if($editing)
    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:project.edit :project="$editing" />
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
                                <th class="p-1">No</th>
                                <th class="p-1">Project Name</th>
                                <th class="p-1">Client</th>
                                <th class="p-1">Project Period</th>
                                <th class="p-1" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td class="p-1">{{ $loop->iteration}}</td>
                                    <td class="p-1">{{ $project->project_name }}</td>
                                    <td class="p-1">{{ $project->client}}</td>
                                    <td class="p-1">{{ $project->project_period }}</td>
                                    {{-- <td>{{ $project->type->project_type }}</td> --}}
                                    <td class="p-1">
                                        <button wire:click="detailProject('{{$project->id}}')">Detail</button>
                                    </td>
                                    <td class="p-1">
                                        <button wire:click="editProject('{{$project->id}}')">Edit</button>
                                    </td>
                                    <td class="p-1">
                                        <button wire:click="deleteProject('{{$project->id}}')" wire:confirm="Are you sure you want to delete this project?">Delete</button>
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
