<?php

use App\Models\POI;
use Livewire\Volt\Component;

new class extends Component {
    public $reportData;
    public $totalCount;
    public $acceptedCount;
    public $rejectedCount;
    public $pendingCount;

    function mount (): void
    {
        $this->getInfo();
    }

    public function getInfo(): void
    {
        $this->totalCount = POI::where('contributor_id', Auth::id())->whereDate('input_time', now()->toDateString())->count();
        $this->acceptedCount = POI::where('contributor_id', Auth::id())->whereDate('input_time', now()->toDateString())->where('status', 'accepted')->count();
        $this->rejectedCount = POI::where('contributor_id', Auth::id())->whereDate('input_time', now()->toDateString())->where('status', 'rejected')->count();
        $this->pendingCount = POI::where('contributor_id', Auth::id())->whereDate('input_time', now()->toDateString())->where('status', 'pending')->count();

        $this->reportData = POI::where('contributor_id', Auth::id())
            ->get();
    }
}; ?>

<div>
    <div class="my-10 mx-5">
        <div class="flex gap-x-5">
            <div class="px-2 py-2 bg-flash-white rounded-lg">
                <p class="text-md text-indigo font-bold">Total Report Today</p>
                <p>{{$totalCount}}</p>
            </div>
            <div class="px-2 py-2 bg-flash-white rounded-lg">
                <p class="text-md text-indigo font-bold">Total Report Accepted</p>
                <p>{{$acceptedCount}}</p>
            </div>
            <div class="px-2 py-2 bg-flash-white rounded-lg">
                <p class="text-md text-indigo font-bold">Total Report Rejected</p>
                <p>{{$rejectedCount}}</p>
            </div>
            <div class="px-2 py-2 bg-flash-white rounded-lg">
                <p class="text-md text-indigo font-bold">Total Report Pending</p>
                <p>{{$pendingCount}}</p>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <p class="text-2xl text-indigo font-bold mb-1">Report Data</p>
        <div class="mb-10 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-0 text-gray-900">
                <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                    <thead>
                        <tr class="text-indigo font-semibold bg-flash-white">
                            <th class="py-1 pl-5 w-1/12">No</th>
                            <th class="py-1 w-2/12">Location name</th>
                            <th class="py-1 w-2/12">Input time</th>
                            <th class="py-1 w-2/12">Curate time</th>
                            <th class="py-1 w-1/12">Status</th>
                            <th class="py-1 w-2/12">Reject reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $data)
                            <tr class="bg-white shadow-md">
                                <td class="text-indigo pl-5 py-1">{{ $loop->iteration }}</td>
                                <td class="text-indigo py-1">{{ $data->location_name }}</td>
                                <td class="text-indigo py-1">{{ $data->input_time }}</td>
                                <td class="text-indigo py-1">{{ $data->curate_time}}</td>
                                @if($data->status == 'accepted')
                                    <td class="text-green-700 py-1">{{ $data->status }}</td>
                                @elseif($data->status == 'rejected')
                                    <td class="text-red-700 py-1">{{ $data->status }}</td>
                                @else
                                    <td class="text-yellow-400 py-1">{{ $data->status }}</td>
                                @endif
                                <td class="text-indigo py-1">{{ $data->reject_reason }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>




    

