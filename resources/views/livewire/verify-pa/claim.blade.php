<?php

use App\Models\PA;
use Livewire\Volt\Component;

new class extends Component {
    public $hasPendingData;
    public $claimId;
    
    public function mount(): void
    {
        $this->hasPendingData = PA::where('curator_id', Auth::id())
            ->whereNotNull('claim_id')
            ->whereNull('claim_time_end')
            ->exists();

        $latestClaim = PA::where('curator_id', Auth::id())
            ->whereNotNull('claim_id')
            ->orderBy('claim_time_start', 'desc')
            ->first();
        if ($latestClaim) {
            $this->claimId = $latestClaim->claim_id;
        }
    }

    public function claim(): void
    {
        $claimedData = PA::oldest('id')->whereNull('claim_id')->take(10)->get();

        if ($claimedData->isEmpty()) {
            // warning message
        } else {
            $this->claimId = Str::ulid()->toBase32();
            $curatorId = Auth::id();
            $startTime = now();

            foreach ($claimedData as $data) {
                $data->update([
                    'claim_id' => $this->claimId,
                    'claim_time_start' => $startTime,
                    'curator_id' => Auth::id(),
                ]);
            }

            $this->hasPendingData = true;
            $this->dispatch('claim-request');
        }

    }
    

    public function view(string $claimId): void
    {
        Session::put('current_claim_id', $claimId);

        redirect()->route('verify.pa.view');
    }

}; ?>

<div>
    @if($hasPendingData)
        <div class="bg-white w-96 px-5 py-5">
            <p class="mb-10">View data to verify report</p>
            <x-primary-button wire:click="view('{{ $claimId }}')">View Data</x-primary-button>
        </div>
    @else
        <div class="bg-white w-96 px-5 py-5">
            <p class="mb-10">Claim data to start verify report</p>
            <x-primary-button wire:click="claim()">Claim Data</x-primary-button>
        </div>
    @endif

</div>
