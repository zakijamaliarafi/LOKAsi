<?php

use App\Models\POI;
use Livewire\Volt\Component;

new class extends Component {
    public $hasPendingData;
    public $claimId;
    
    public function mount(): void
    {
        $this->hasPendingData = POI::where('curator_id', Auth::id())
            ->whereNotNull('claim_id')
            ->whereNull('claim_time_end')
            ->exists();

        $latestClaim = POI::where('curator_id', Auth::id())
            ->whereNotNull('claim_id')
            ->orderBy('claim_time_start', 'desc')
            ->first();
        if ($latestClaim) {
            $this->claimId = $latestClaim->claim_id;
        }
    }

    public function claim(): void
    {
        $claimedData = POI::oldest('id')->whereNull('claim_id')->take(10)->get();

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
            $this->dispatch('claim-poi-request');
        }

    }
    

    public function view(string $claimId): void
    {
        Session::put('current_claim_id_poi', $claimId);

        redirect()->route('verify.poi.view');
    }
}; ?>

<div>
    @if($hasPendingData)
        <div class="bg-flash-white w-96 px-5 py-5 rounded-lg">
            <p class="text-lg text-indigo font-bold mb-10">List data to verify report</p>
            <x-primary-button wire:click="view('{{ $claimId }}')" class="text-lg text-white rounded-lg">List Data</x-primary-button>
        </div>
    @else
        <div class="bg-flash-white w-96 px-5 py-5 rounded-lg">
            <p class="text-lg text-indigo font-bold mb-10">Request data to start verify report</p>
            <x-primary-button wire:click="claim()" class="text-lg text-white rounded-lg">Request Data</x-primary-button>
        </div>
    @endif
</div>
