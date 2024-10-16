<?php

use App\Models\POI;
use App\Models\Payment;
use Livewire\Volt\Component;
Use Carbon\Carbon;

new class extends Component {
    public $approval;
    public $benefit;
    public $date;
    public $name;
    public $bank = null;
    public $account;

    public function mount()
    {
        $this->approval = POI::where('contributor_id', Auth::id())
            ->where('status', 'accepted')
            ->count();
        
        $this->benefit = $this->approval * 100;

        $this->date = Carbon::now()->format('Y-m-d');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'bank' => 'required',
            'account' => 'required',
        ]);

        if($this->approval>=1000){
            $payment = Payment::create([
                'bank_name' => $this->bank,
                'account_number' => $this->account,
                'account_name' => $this->name,
                'total_data' => $this->approval,
                'total_benefit' => $this->benefit,
                'claim_date' => $this->date,
                'contributor_id' => auth()->user()->id,
            ]);

            POI::where('contributor_id', auth()->user()->id)
                ->whereNull('payment_id')
                ->update(['payment_id' => $payment->id]);

            redirect()->route('mobile.history');
        } else {
            redirect()->route('mobile.history');
        }
    }

}; ?>

<div class="mx-4">
    <div class="flex justify-start gap-x-2 items-center mb-4">
        <a href="/"><img class="h-12" src="{{ asset('img/back.svg') }}" alt=""></a>
        <p class="text-indigo text-xl font-bold">Claim Payment</p>
    </div>
    <div class="mb-4">
        <p class="text-slate-400">Additional Information</p>
        <div class="bg-slate-200 p-4 text-indigo border border-indigo rounded-lg">
            <p>Total Curation Approval : {{$approval}}</p>
            <p>Total Claim Benefit : {{$benefit}}</p>
            <p>Claimed On : {{$date}}</p>
        </div>
    </div>
    <div>
        <form wire:submit.prevent="submit">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Full Name</label>
                <input type="text" id="name" wire:model="name" class="mt-1 block w-full border-b-indigo border-b-4 border-t-0 border-r-0 border-l-0 shadow-sm">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="bank" class="block text-gray-700">Bank Name</label>
                <select id="bank" wire:model="bank" class="mt-1 block w-full border-b-indigo border-b-4 border-t-0 border-r-0 border-l-0 shadow-sm">
                    <option value="">none</option>
                    <option value="BCA">BCA</option>
                    <option value="BRI">BRI</option>
                    <option value="Mandiri">Mandiri</option>
                    <option value="Danamon">Danamon</option>
                    <option value="BTN">BTN</option>
                </select>
                @error('bank') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="account" class="block text-gray-700">Account Number</label>
                <input type="text" id="account" wire:model="account" class="mt-1 block w-full border-b-indigo border-b-4 border-t-0 border-r-0 border-l-0 shadow-sm">
                @error('account') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-primary-button type="submit" class="w-full rounded-lg">Confirm</x-primary-button>
        </form>
    </div>
</div>
