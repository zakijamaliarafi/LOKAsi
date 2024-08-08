<?php

use App\Models\PA;
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

    #[On('claim-request')]
    public function getInfo(): void
    {
        $this->acceptedCount = PA::where('status', 'accepted')
            ->where('curator_id', Auth::id())
            ->count();

        $this->rejectedCount = PA::where('status', 'rejected')
            ->where('curator_id', Auth::id())
            ->count();

        $this->claimedCount = PA::whereNotNull('claim_id')
            ->where('curator_id', Auth::id())
            ->count();
    }

}; ?>

<div>
    <div class="flex gap-x-5">
        <div class="px-2 py-2 bg-white">
            <p>Total Accepted</p>
            <p>{{$acceptedCount}}</p>
        </div>
        <div class="px-2 py-2 bg-white">
            <p>Total Rejected</p>
            <p>{{$rejectedCount}}</p>
        </div>
        <div class="px-2 py-2 bg-white">
            <p>Total Claimed</p>
            <p>{{$claimedCount}}</p>
        </div>
    </div>
</div>
