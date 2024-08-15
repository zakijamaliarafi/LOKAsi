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
        <p class="text-2xl text-indigo font-bold">Data</p>
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-0 text-gray-900">
                
                <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                    <thead>
                        <tr class="text-indigo font-semibold bg-flash-white">
                            <th class="py-1 pl-5 w-1/6">No</th>
                            <th class="py-1 w-2/6">Claim Time</th>
                            <th class="py-1 w-1/6">Accepted Data</th>
                            <th class="py-1 w-1/6">Rejected Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($claimedData as $data)
                            <tr class="bg-white shadow-md">
                                <td class="text-indigo pl-5 py-1">{{ $loop->iteration }}</td>
                                <td class="text-indigo py-1">{{ $data->claim_time_start }}</td>
                                <td class="text-green-700 py-1">{{ $data->accepted_count }} Accepted</td>
                                <td class="text-red-700 py-1">{{ $data->rejected_count }} Rejected</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
