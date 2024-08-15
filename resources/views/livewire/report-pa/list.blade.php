<?php

use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $result;

    public $list = true;

    public $dailyViewCurator = false;
    public $monthlyViewCurator = false;

    public function mount(): void
    {
        $this->getInfo();
    }

    public function getInfo(): void
    {
        $this->result = DB::table('reports_pa')
            ->join('users', 'reports_pa.curator_id', '=', 'users.id')
            ->select(
                'users.id as curator_id',
                'users.name as curator_name',
                DB::raw('MAX(reports_pa.claim_time_end) as latest_claim_time_end')
            )
            ->whereNotNull('reports_pa.curator_id')
            ->groupBy('users.id', 'users.name')
            ->get();

        foreach ($this->result as $row) {
            $latestDate = Carbon::parse($row->latest_claim_time_end)->toDateString();
            
            $counts = DB::table('reports_pa')
                ->where('curator_id', $row->curator_id)
                ->whereDate('claim_time_end', $latestDate)
                ->selectRaw('
                    SUM(CASE WHEN status = "accepted" THEN 1 ELSE 0 END) as accepted_count,
                    SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_count
                ')
                ->first();
            
            $row->accepted_count = $counts->accepted_count;
            $row->rejected_count = $counts->rejected_count;
        }
        // dd($result);
    }

    public function viewCuratorDaily(): void
    {
        $this->clear();
        $this->dailyViewCurator = true;
    }

    public function viewCuratorMonthly(): void
    {
        $this->clear();
        $this->monthlyViewCurator = true;
    }

    public function back(): void
    {
        $this->clear();
        $this->list = true;
    }

    public function clear(): void
    {
        $this->list = false;
        $this->dailyViewCurator = false;
        $this->monthlyViewCurator = false;
    }

}; ?>


<div class="pt-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if($list)
        <div class="flex justify-end">
            <div class="bg-flash-white w-[24rem] px-5 py-5 mb-5 rounded-lg">
                <p class="text-lg text-indigo text-center font-bold mb-5">Manage Report</p>
                <div class="flex justify-center">
                    <x-primary-button wire:click="viewCuratorDaily" class="text-md text-white rounded-lg px-2 py-1">Curator Report</x-primary-button>
                </div>
            </div>
        </div>
        <p class="text-2xl text-indigo font-bold">Data</p>
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-0 text-gray-900">
                <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                    <thead>
                        <tr class="text-indigo font-semibold bg-flash-white">
                            <th class="py-1 px-2 pl-5">No</th>
                            <th class="py-1 px-2">Curator</th>
                            <th class="py-1 px-2">Last activity</th>
                            <th class="py-1 px-2">Accepted Data</th>
                            <th class="py-1 px-2">Rejected Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!is_null($result))
                            @foreach($result as $data)
                                <tr class="bg-white shadow-md">
                                    <td class="text-indigo py-1 px-2 pl-5">{{ $loop->iteration }}</td>
                                    <td class="text-indigo py-1 px-2">{{ $data->curator_name }}</td>
                                    <td class="text-indigo py-1 px-2">{{ $data->latest_claim_time_end }}</td>
                                    <td class="text-green-700 py-1 px-2 text-center">{{ $data->accepted_count }}</td>
                                    <td class="text-red-700 py-1 px-2 text-center">{{ $data->rejected_count }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($dailyViewCurator)
            <button wire:click="back" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</button>
            <x-primary-button wire:click="viewCuratorDaily" class="text-sm text-white rounded-lg px-2 py-1">Daily Report</x-primary-button>
            <button wire:click="viewCuratorMonthly" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Monthly Report</button>
            <livewire:report-pa.view-curator-daily />
        @endif

        @if($monthlyViewCurator)
            <button wire:click="back" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</button>
            <button wire:click="viewCuratorDaily" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Daily Report</button>
            <x-primary-button wire:click="viewCuratorMonthly" class="text-sm text-white rounded-lg px-2 py-1">Monthly Report</x-primary-button>
            <livewire:report-pa.view-curator-monthly />
        @endif

    </div>
</div>
