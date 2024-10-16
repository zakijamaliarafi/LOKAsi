<?php

use App\Models\Payment;
use Livewire\Volt\Component;

new class extends Component {
    public $paymentData;

    function mount (): void
    {
        $this->paymentData = Payment::where('contributor_id', Auth::id())
            ->orderBy('claim_date', 'desc')
            ->get();
    }
}; ?>

<div class="min-h-screen overflow-y-auto">
    <div class="flex justify-start gap-x-2 items-center mb-4">
        <a href="/"><img class="h-12" src="{{ asset('img/back.svg') }}" alt=""></a>
        <p class="text-indigo text-xl font-bold">Claim Payment</p>
    </div>
    <div class="max-w-7xl mx-auto ml-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="mx-auto text-gray-900">
                <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                    <thead>
                        <tr class="text-indigo font-semibold bg-flash-white">
                            <th class="py-1 pl-5 px-2">No</th>
                            <th class="py-1 px-2">Claim Date</th>
                            <th class="py-1 px-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentData as $data)
                            <tr class="bg-white shadow-md">
                                <td class="text-indigo pl-5 py-1 px-2">{{ $loop->iteration }}</td>
                                <td class="text-indigo py-1 px-2">
                                    <p>{{ $data->claim_date }}</p>
                                    <p>Total Claim Data : {{$data->total_data }}</p>
                                    <p>Total Benefit : Rp. {{$data->total_benefit}}</p>
                                </td>
                                <td class="text-indigo py-1 px-2">{{ $data->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

       
</div>
