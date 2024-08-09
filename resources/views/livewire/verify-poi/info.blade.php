<?php

use App\Models\POI;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public $acceptedCount;
    public $rejectedCount;
    public $claimedCount;

    public function mount(): void
    {
        $this->getInfo();
    }

    #[On('claim-poi-request')]
    public function getInfo(): void
    {
        $this->acceptedCount = POI::where('status', 'accepted')
            ->where('curator_id', Auth::id())
            ->count();

        $this->rejectedCount = POI::where('status', 'rejected')
            ->where('curator_id', Auth::id())
            ->count();

        $this->claimedCount = POI::whereNotNull('claim_id')
            ->where('curator_id', Auth::id())
            ->count();
    }
}; ?>

<div>
    <div class="flex gap-x-5">
        <div class="px-2 py-2 bg-flash-white rounded-lg">
            <p class="text-md text-indigo font-bold">Total Accepted</p>
            <p>{{$acceptedCount}}</p>
        </div>
        <div class="px-2 py-2 bg-flash-white rounded-lg">
            <p class="text-md text-indigo font-bold">Total Rejected</p>
            <p>{{$rejectedCount}}</p>
        </div>
        <div class="px-2 py-2 bg-flash-white rounded-lg">
            <p class="text-md text-indigo font-bold">Total Claimed</p>
            <p>{{$claimedCount}}</p>
        </div>
    </div>
</div>
