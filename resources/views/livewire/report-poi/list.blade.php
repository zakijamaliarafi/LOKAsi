<?php

use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $result;
    public $contributor_data;

    public $list = true;

    public $dailyViewCurator = false;
    public $monthlyViewCurator = false;
    public $dailyViewContributor = false;
    public $monthlyViewContributor = false;

    public function mount(): void
    {
        $this->getInfo();
    }

    public function getInfo(): void
    {
        $this->result = DB::table('reports_poi')
            ->join('users', 'reports_poi.curator_id', '=', 'users.id')
            ->select(
                'users.id as curator_id',
                'users.name as curator_name',
                DB::raw('MAX(GREATEST(
                    COALESCE(curate_time, "1970-01-01 00:00:00"),
                    COALESCE(claim_time_start, "1970-01-01 00:00:00"),
                    COALESCE(claim_time_end, "1970-01-01 00:00:00")
                )) AS latest_activity')
            )
            ->whereNotNull('reports_poi.curator_id')
            ->groupBy('users.id', 'users.name')
            ->get();

        foreach ($this->result as $row) {
            // $latestDate = Carbon::parse($row->latest_activity)->toDateString();
            
            $counts = DB::table('reports_poi')
                ->where('curator_id', $row->curator_id)
                ->selectRaw('
                    SUM(CASE WHEN status = "accepted" THEN 1 ELSE 0 END) as accepted_count,
                    SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_count,
                    SUM(CASE WHEN claim_id IS NOT NULL THEN 1 ELSE 0 END) as claimed_count
                ')
                ->first();
            
            $row->accepted_count = $counts->accepted_count;
            $row->rejected_count = $counts->rejected_count;
            $row->claimed_count = $counts->claimed_count;
        }
        // dd($result);

        $this->contributor_data = DB::table('reports_poi')
            ->join('users', 'reports_poi.contributor_id', '=', 'users.id')
            ->select(
                'users.id as contributor_id',
                'users.name as contributor_name',
                DB::raw('MAX(input_time) AS latest_activity')
            )
            ->groupBy('users.id', 'users.name')
            ->get();

        foreach ($this->contributor_data as $row) {
            // $latestDate = Carbon::parse($row->latest_activity)->toDateString();
            
            $counts = DB::table('reports_poi')
                ->where('contributor_id', $row->contributor_id)
                ->selectRaw('
                    COUNT(*) as input_count,
                    SUM(CASE WHEN status = "accepted" THEN 1 ELSE 0 END) as accepted_count,
                    SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_count,
                    SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count
                ')
                ->first();

            $row->input_count = $counts->input_count;
            $row->accepted_count = $counts->accepted_count;
            $row->rejected_count = $counts->rejected_count;
            $row->pending_count = $counts->pending_count;
        }
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

    public function viewContributorDaily(): void
    {
        $this->clear();
        $this->dailyViewContributor = true;
    }

    public function viewContributorMonthly(): void
    {
        $this->clear();
        $this->monthlyViewContributor = true;
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
        $this->dailyViewContributor = false;
        $this->monthlyViewContributor = false;
    }

}; ?>


<div class="pt-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if($list)
        <div class="flex justify-end">
            <div class="bg-flash-white w-[28rem] px-5 py-5 mb-5 rounded-lg">
                <p class="text-lg text-indigo text-center font-bold mb-5">Manage Report</p>
                <div class="flex justify-around">
                    <x-primary-button wire:click="viewCuratorDaily" class="text-md text-white rounded-lg px-2 py-1">Curator Report</x-primary-button>
                    <x-primary-button wire:click="viewContributorDaily" class="text-md text-white rounded-lg px-2 py-1">Contributor Report</x-primary-button>
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
                            <th class="py-1 px-2">Total Accepted</th>
                            <th class="py-1 px-2">Total Rejected</th>
                            <th class="py-1 px-2">Total Claimed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!is_null($result))
                            @foreach($result as $data)
                                <tr class="bg-white shadow-md">
                                    <td class="text-indigo py-1 px-2 pl-5">{{ $loop->iteration }}</td>
                                    <td class="text-indigo py-1 px-2">{{ $data->curator_name }}</td>
                                    <td class="text-indigo py-1 px-2">{{ $data->latest_activity }}</td>
                                    <td class="text-green-700 py-1 px-2 text-center">{{ $data->accepted_count }}</td>
                                    <td class="text-red-700 py-1 px-2 text-center">{{ $data->rejected_count }}</td>
                                    <td class="text-yellow-700 py-1 px-2 text-center">{{ $data->claimed_count }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="overflow-hidden shadow-sm sm:rounded-lg my-5">
            <div class="px-0 text-gray-900">
                <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                    <thead>
                        <tr class="text-indigo font-semibold bg-flash-white">
                            <th class="py-1 px-2 pl-5">No</th>
                            <th class="py-1 px-2">Contributor</th>
                            <th class="py-1 px-2">Last activity</th>
                            <th class="py-1 px-2">Total Report</th>
                            <th class="py-1 px-2">Total Report Accepted</th>
                            <th class="py-1 px-2">Total Report Rejected</th>
                            <th class="py-1 px-2">Total Report Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!is_null($contributor_data))
                            @foreach($contributor_data as $data)
                                <tr class="bg-white shadow-md">
                                    <td class="text-indigo py-1 px-2 pl-5">{{ $loop->iteration }}</td>
                                    <td class="text-indigo py-1 px-2">{{ $data->contributor_name }}</td>
                                    <td class="text-indigo py-1 px-2">{{ $data->latest_activity }}</td>
                                    <td class="text-indigo py-1 px-2 text-center">{{ $data->input_count }}</td>
                                    <td class="text-green-700 py-1 px-2 text-center">{{ $data->accepted_count }}</td>
                                    <td class="text-red-700 py-1 px-2 text-center">{{ $data->rejected_count }}</td>
                                    <td class="text-yellow-700 py-1 px-2 text-center">{{ $data->pending_count }}</td>
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
            <livewire:report-poi.view-curator-daily />
        @endif

        @if($monthlyViewCurator)
            <button wire:click="back" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</button>
            <button wire:click="viewCuratorDaily" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Daily Report</button>
            <x-primary-button wire:click="viewCuratorMonthly" class="text-sm text-white rounded-lg px-2 py-1">Monthly Report</x-primary-button>
            <livewire:report-poi.view-curator-monthly />
        @endif

        @if($dailyViewContributor)
            <button wire:click="back" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</button>
            <x-primary-button wire:click="viewContributorDaily" class="text-sm text-white rounded-lg px-2 py-1">Daily Report</x-primary-button>
            <button wire:click="viewContributorMonthly" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Monthly Report</button>
            <livewire:report-poi.view-contributor-daily />
        @endif

        @if($monthlyViewContributor)
            <button wire:click="back" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</button>
            <button wire:click="viewContributorDaily" class="inline-flex items-center justify-center px-4 py-1.5 bg-flash-white border border-transparent font-medium text-indigo rounded-lg tracking-widest hover:bg-light-blue hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Daily Report</button>
            <x-primary-button wire:click="viewContributorMonthly" class="text-sm text-white rounded-lg px-2 py-1">Monthly Report</x-primary-button>
            <livewire:report-poi.view-contributor-monthly />
        @endif

    </div>
</div>
