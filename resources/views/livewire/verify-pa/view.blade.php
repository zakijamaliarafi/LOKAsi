<?php

use App\Models\PA;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

new class extends Component {
    public PA $data;
    public $streetNameStatus = null;
    public $houseNumberStatus = null;
    public $houseNumberUpdate = null;
    public $rejectReason = null;

    public function mount(): void
    {
        $this->getData();
    }

    public function getData(): void
    {
        $claimId = Session::get('current_claim_id');
        
        if(is_null($claimId)) {
            redirect()->route('verify.pa');
        }

        $report = PA::oldest('id')
            ->where('claim_id', $claimId)
            ->where('status', 'pending')
            ->first();

        if ($report) {
            $this->data = $report;
            $this->resetForm();
        } else {
            $hasNullClaimTimeEnd = PA::whereNull('claim_time_end')
                ->where('claim_id', $claimId)
                ->exists();

            if($hasNullClaimTimeEnd) {
                PA::where('claim_id', $claimId)
                    ->update(['claim_time_end' => now()]);

                Session::forget('current_claim_id');

                redirect()->route('verify.pa');
            }else{
                redirect()->route('verify.pa');
            }
        }

        $this->renderMap();
    }

    public function renderMap(): void
    {
        $this->dispatch('init-map', [
            'latitude' => $this->data->latitude,
            'longitude' => $this->data->longitude,
            'name' => $this->data->name,
        ]);
    }

    public function resetForm(): void
    {
        $this->resetErrorBag();
        $this->streetNameStatus = null;
        $this->houseNumberStatus = null;
        $this->houseNumberUpdate = null;
        $this->rejectReason = null;
    }

    public function accept(): void
    {
        $validator = Validator::make(
            [
                'streetNameStatus' => $this->streetNameStatus,
                'houseNumberStatus' => $this->houseNumberStatus,
                'houseNumberUpdate' => $this->houseNumberUpdate,
                'rejectReason' => $this->rejectReason,
            ],
            [
                'streetNameStatus' => 'required',
                'houseNumberStatus' => ['required', 'prohibited_if:houseNumberStatus,nonumber'],
                'houseNumberUpdate' => ['required_if:houseNumberStatus,false', 'prohibited_if:houseNumberStatus,true'],
                'rejectReason' => 'prohibited',
            ],
            [
                'streetNameStatus.required' => 'To accept data, Street name status is required.',
                'houseNumberStatus.required' => 'To accept data, House number status is required.',
                'houseNumberStatus.prohibited_if' => 'If there is no house number, data must be rejected.',
                'houseNumberUpdate.required_if' => 'To accept data, House number update is required.',
                'houseNumberUpdate.prohibited_if' => 'If house number is true, house number update must be empty.',
                'rejectReason.prohibited' => 'To accept data, reject reason must be empty.',
                
            ]
        );

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            $this->renderMap();
            return;
        }

        $this->data->street_name_status = $this->streetNameStatus;
        $this->data->house_number_status = $this->houseNumberStatus;
        if($this->houseNumberUpdate !== null ) {
            $this->data->house_number_update = $this->houseNumberUpdate;
        }
        $this->data->status = 'accepted';
        $this->data->curate_time = now();
        $this->data->save();

        $this->getData();
    }

    public function reject(): void
    {
        $validator = Validator::make(
            [
                'rejectReason' => $this->rejectReason,
            ],
            [
                'rejectReason' => 'required',
            ],
            [
                'rejectReason.required' => 'To reject data, reject reason is required.',
            ]
        );

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            $this->renderMap();
            return;
        }

        $this->data->reject_reason = $this->rejectReason;
        $this->data->status = 'rejected';
        $this->data->curate_time = now();
        $this->data->save();

        $this->getData();
    }


}; ?>

<div class="flex">
    <div class="h-screen w-1/2 bg-white">
        <form wire:submit.prevent>
            <div class="pt-10 pl-10 text-2xl text-indigo font-bold">
                Address Information
            </div>
            <div class="pt-5 pl-10 text-xl">
                @if(is_null($data->street_name))
                    -
                @else
                    <span class="text-indigo font-bold">Street name:</span> <span class="text-gray-700">{{ $data->street_name }}</span>
                @endif
            </div>
            <div class="pl-10">
                <input id="trueName" type="radio" value="true" wire:model="streetNameStatus">
                <label for="trueName">True</label>
                <input id="falseName" type="radio" value="false" wire:model="streetNameStatus" class="ml-5">
                <label for="falseName">False</label>
                <input id="unnamed" type="radio" value="unnamed" wire:model="streetNameStatus" class="ml-5">
                <label for="unnamed">Unnamed street</label>
            </div>
            <div class="pl-10 text-red-500">
                @error('streetNameStatus')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="pt-5 pl-10 text-xl">
                @if(is_null($data->house_number))
                    -
                @else
                <span class="text-indigo font-bold">Number:</span> <span class="text-gray-700">{{ $data->house_number }}</span>
                @endif
            </div>
            <div class="pl-10">
                <input id="trueNumber" type="radio" value="true" wire:model="houseNumberStatus">
                <label for="trueNumber">True</label>
                <input id="falseNumber" type="radio" value="false" wire:model="houseNumberStatus" class="ml-5">
                <label for="falseNumber">False</label>
                <input id="noNumber" type="radio" value="nonumber" wire:model="houseNumberStatus" class="ml-5">
                <label for="noNumber">No number</label>
            </div>
            <div class="pl-10 text-red-500">
                @error('houseNumberStatus')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-5 pl-10 text-xl">
                <label for="number_update" class="block text-indigo font-bold">Update Number</label>
                <input id="number_update" type="text" wire:model="houseNumberUpdate" class="h-8 w-48">
            </div>
            <div class="pl-10 text-red-500">
                @error('houseNumberUpdate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <div class="pl-10 pt-5 text-xl">
                <label for="option" class="block text-indigo font-bold">Select reject reason:</label>
                <select id="option" wire:model="rejectReason" class="h-10 w-48">
                    <option value="">none</option>
                    <option value="no streetview">no streetview</option>
                    <option value="no number">no number</option>
                    <option value="no building">no building</option>
                </select>
            </div>
            <div class="pl-10 text-red-500">
                @error('rejectReason')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="pl-10 pt-5 text-xl">
                <x-primary-button type="button" wire:click="accept" class="text-base rounded-lg px-2 py-1">Accept</x-primary-button>
                <x-secondary-button type="button" wire:click="reject" class="text-base rounded-lg px-5 py-3">Reject</x-secondary-button>
            </div>
        </form>
    </div>

    <div class="h-screen w-1/2">
        <div id="map" class="h-full"></div>
    </div>

    <script src="{{ asset('js/config.js') }}"></script>
    <script>var apikey = config.MAP_API_KEY;</script>

    <!-- prettier-ignore -->
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: apikey, v: "weekly"});</script>

<script>
    window.addEventListener('init-map', event => {
        console.log('Event:', event);
        // Extract latitude, longitude, and name from event detail
        const { latitude, longitude, name } = event.detail[0];
        
        console.log(latitude, longitude, name);
        // Convert latitude and longitude to numbers
        const lat = parseFloat(latitude);
        const lng = parseFloat(longitude);

        // Check if conversion was successful
        if (isNaN(lat) || isNaN(lng)) {
            console.error("Invalid latitude or longitude values.");
            return;
        }

        // Initialize the map with converted numeric values
        initMap(lat, lng, name);
    });

    async function initMap(latitude, longitude, name) {
        // The location
        const position = { lat: latitude, lng: longitude };

        // Request needed libraries.
        //@ts-ignore
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

        // The map, centered at the position
        const map = new Map(document.getElementById("map"), {
            zoom: 18,
            center: position,
            mapId: "DEMO_MAP_ID",
        });

        // The marker, positioned at the position
        const marker = new AdvancedMarkerElement({
            map: map,
            position: position,
            title: name,
        });
    }
</script>

</div>
