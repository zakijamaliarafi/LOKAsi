<?php

use App\Models\POI;
use Livewire\Volt\Component;
use App\Livewire\Actions\Logout;

new class extends Component {
    public $reportData;
    public $totalCount;
    public $dailyCount;
    public $contribution;
    public $approve;

    function mount (): void
    {
        $this->getInfo();
    }

    public function getInfo(): void
    {
        $this->totalCount = POI::where('contributor_id', Auth::id())->where('payment_id', null)->count();
        $this->dailyCount = POI::where('contributor_id', Auth::id())
            ->whereDate('input_time', today())
            ->where('payment_id', null)
            ->count();

        $this->reportData = POI::where('contributor_id', Auth::id())
            ->orderBy('input_time', 'desc')
            ->where('payment_id', null)
            ->take(5)
            ->get();

        $this->contribution = POI::where('contributor_id', Auth::id())
            ->where('payment_id', null)
            ->count();

        $this->approve = POI::where('contributor_id', Auth::id())
            ->where('status', 'accepted')
            ->where('payment_id', null)
            ->count();
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="min-h-screen pb-20">
    <div class="w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-xl font-semibold text-gray-900 flex justify-between">
                    <p>{{ Auth::user()->name }}</p>
                    <button wire:click="logout" class="text-sm text-start">
                        {{ __('Log Out') }}
                    </button>
                </div> 
            </div>
        </div>
    
        <div class="my-1 mx-5">
            <div class="flex gap-x-5">
                <div class="px-2 py-2 bg-flash-white rounded-lg">
                    <p class="text-md text-indigo font-bold">Total Report</p>
                    <p>{{$totalCount}}</p>
                </div>
                <div class="px-2 py-2 bg-flash-white rounded-lg">
                    <p class="text-md text-indigo font-bold">Daily Report</p>
                    <p>{{$dailyCount}}</p>
                </div>
                <div class="px-2 py-2 bg-flash-white rounded-lg">
                    <p class="text-md text-indigo font-bold">Daily Target</p>
                    <p>75</p>
                </div>
            </div>
        </div>
    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-xl font-semibold text-gray-900">
                    <p>Welcome back to <span class="text-2xl text-indigo">LOKA</span><span class="text-[#FF0000]">SI</span>, {{ Auth::user()->name }}</p>
                </div> 
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-2xl text-indigo font-bold mb-1">Last Activity</p>
                    <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                        <thead>
                            <tr class="text-indigo font-semibold bg-flash-white">
                                <th class="py-1 pl-5 px-2">No</th>
                                <th class="py-1 px-2">Location name</th>
                                <th class="py-1 px-2">Input time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportData as $data)
                                <tr class="bg-white shadow-md">
                                    <td class="text-indigo pl-5 py-1">{{ $loop->iteration }}</td>
                                    <td class="text-indigo py-1">{{ $data->location_name }}</td>
                                    <td class="text-indigo py-1">{{ $data->input_time }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow-sm sm:rounded-lg">
                <div class="pl-6 pb-1 pt-4 text-xl font-semibold text-gray-900">
                    <p>Claim Payment</p>
                </div>
                <div class="pl-6 pb-1 text-sm font-normal text-gray-900">
                    <p>Total Contribution : {{$contribution}}</p>
                    <p>Total Curation Approve : {{$approve}}</p>
                </div>
                <div class="flex justify-between mx-6 mt-2">
                    @if($approve>=1000)
                    <div>
                        <a href="/m/payment"><button class="inline-flex items-center justify-center px-4 py-2 bg-white border border-indigo font-medium text-indigo rounded-lg">Claim</button></a>    
                    </div>
                    @else
                    <div>
                        <button class="inline-flex items-center justify-center px-4 py-2 bg-white border border-indigo font-medium text-indigo rounded-lg">Claim</button>    
                    </div>
                    @endif
                    <div>
                        <a href="/m/history"><button class="inline-flex items-center justify-center px-4 py-2 bg-white border border-indigo font-medium text-indigo rounded-lg">Claim History</button></a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    

    <div class="h-20 bg-indigo flex justify-around items-center text-white fixed bottom-0 left-0 right-0 z-10">
        <a href="/">
            <img class="h-10" src="{{ asset('img/home-mobile-icon.svg') }}" alt="">
        </a>
        <a href="/map">
            <img class="h-10" src="{{ asset('img/map.svg') }}" alt="">
        </a>
    </div>
</div>




    

