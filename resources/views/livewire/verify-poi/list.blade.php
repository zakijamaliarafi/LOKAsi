<?php

use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public $claimedData;

    public function mount(): void
    {
        $this->getInfo();
    }

    #[On('claim-poi-request')]
    public function getInfo(): void
    {
        $this->claimedData = DB::table('reports_poi')
            ->select('claim_id', 'claim_time_start',
                DB::raw('SUM(CASE WHEN status = "accepted" THEN 1 ELSE 0 END) as accepted_count'),
                DB::raw('SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_count')
            )
            ->where('curator_id', auth()->id())
            ->whereNotNull('claim_id')
            ->groupBy('claim_id', 'claim_time_start')
            ->get();
    }
}; ?>

<div class="pt-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-flash-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <p class="text-xl text-indigo font-bold">Data</p>
                <table class="text-left">
                    <thead>
                        <tr class="text-indigo font-semibold">
                            <th class="py-1 w-1/6">No</th>
                            <th class="py-1 w-2/6">Claim Time</th>
                            <th class="py-1 w-1/6">Accepted Data</th>
                            <th class="py-1 w-1/6">Rejected Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($claimedData as $data)
                            <tr>
                                <td class="text-indigo">{{ $loop->iteration }}</td>
                                <td class="text-indigo">{{ $data->claim_time_start }}</td>
                                <td class="text-green-700">{{ $data->accepted_count }} Accepted</td>
                                <td class="text-red-700">{{ $data->rejected_count }} Rejected</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
