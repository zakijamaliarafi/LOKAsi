<?php

use App\Models\Project;
use Livewire\Volt\Component;

new class extends Component {
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function back(): void
    {
        $this->dispatch('project-detail-canceled');
    }
}; 
?>


<div>
    <div class="mb-5">
        <button wire:click="back">Back</button>
    </div>
    <div>
        <p>Project Name: {{ $project->project_name}}</p>
        <p>Client: {{$project->client}}</p>
        <p>Project Area: {{$project->project_area}}</p>
        <p>Project Volume: {{$project->project_volume}}</p>
        <p>Project Period: {{$project->project_period}}</p>
        <p>Project Type: {{$project->type->project_type}}</p>
    </div>
</div>
