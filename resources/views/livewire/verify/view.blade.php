<?php

use App\Models\Report;
use Livewire\Volt\Component;

new class extends Component {
    public Report $data;
    public $option = null;

    public function mount(): void
    {
        $this->getData();
    }

    public function getData(): void
    {
        $claimId = Session::get('current_claim_id');

        $report = Report::latest('id')
            ->where('claim_id', $claimId)
            ->where('status', 'pending')
            ->first();

        if ($report) {
            $this->data = $report;
        } else {
            $hasNullClaimTimeEnd = Report::whereNull('claim_time_end')
                ->where('claim_id', $claimId)
                ->exists();

            if($hasNullClaimTimeEnd) {
                Report::where('claim_id', $claimId)
                    ->update(['claim_time_end' => now()]);

                Session::forget('current_claim_id');

                redirect()->route('verify');
            }else{
                redirect()->route('verify');
            }
        }

        $this->dispatch('init-map', [
            'latitude' => $this->data->latitude,
            'longitude' => $this->data->longitude,
            'name' => $this->data->name,
        ]);
    }

    public function accept(): void
    {
        $this->data->status = 'accepted';
        $this->data->curate_time = now();
        $this->data->save();

        $this->getData();
    }

    public function reject(): void
    {
        $this->data->status = 'rejected';
        $this->data->curate_time = now();
        $this->data->curate_note = $this->option;
        $this->data->save();

        $this->getData();
    }


}; ?>

<div>
    <div class="h-64 w-[40rem]">
        <div id="map" class="h-full"></div>
    </div>

    <div class="h-64 w-[40rem] bg-white">
        <div class="pt-10 pl-10 text-xl">
            name: {{ $data->name }}
        </div>
        <form wire:submit.prevent>
            <div class="pl-10 pt-5 text-xl">
                <label for="option" class="block">Select reject reason:</label>
                <select id="option" wire:model="option">
                    <option value="">none</option>
                    <option value="data does not match">data does not match</option>
                </select>
            </div>
            <div class="pl-10 pt-5 text-xl">
                <x-primary-button type="button" wire:click="accept">Accept</x-primary-button>
                <x-secondary-button type="button" wire:click="reject">Reject</x-secondary-button>
            </div>
        </form>
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
