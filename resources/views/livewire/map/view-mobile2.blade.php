<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 

new class extends Component {
    public $creating = false;
    public $latitude = null;
    public $longitude = null;

    public function add()
    {
        $this->dispatch('get-coordinate');
    }

    #[On('send-coordinate')]
    public function showAdd($lat, $long)
    {
        $this->latitude = $lat;
        $this->longitude = $long;
        // dd($this->longitude);
        $this->creating = true;
    }

    #[On('close-add')]
    public function closeAdd()
    {
        $this->creating = false;
    }
    
}; ?>

<div class="h-[calc(100dvh)]">
    <div class="h-[calc(100dvh-5rem)] w-screen relative">
        <div id="map" class="h-full" wire:ignore></div>

        <!-- Action Message Component Usage -->
        <x-action-message on="message" class="bg-green-400 w-screen top-0 left-0 text-center">
            {{ session('message', 'Your data has been saved!') }}
        </x-action-message>
        
        @if($creating)
            <livewire:map.add-mobile :latitude="$latitude" :longitude="$longitude"/> 
        @endif
    </div>
    <div class="h-20 bg-indigo flex justify-around text-white items-center fixed bottom-0 left-0 right-0">
        <a href="/">
            <img class="h-10" src="{{ asset('img/home-mobile-icon.svg') }}" alt="">
        </a>
        <button wire:click="add()">
            <img class="h-10" src="{{ asset('img/location-add.svg') }}" alt="">
        </button>
        <a href="/map">
            <img class="h-10" src="{{ asset('img/map.svg') }}" alt="">
        </a>
    </div>
</div>

<script src="{{ asset('js/config.js') }}"></script>
<script>var apikey = config.MAP_API_KEY;</script>

<!-- prettier-ignore -->
<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
    ({key: apikey, v: "weekly"});</script>

<script>
    var Latitude;
    var Longitude;
    window.map = undefined;

    // window.addEventListener('get-coordinate', event => {
    //     console.log('test'+Latitude);
    //     console.log('test'+Longitude);
    // });

    async function initialize() {
        const { Map } = await google.maps.importLibrary("maps");
        const mapOptions = {
            center: new  google.maps.LatLng(0.7893, 113.9213),
            zoom: 4,
            mapId: "DEMO_MAP_ID",
        };
        // assigning to global variable:
        window.map = new Map(document.getElementById("map"), mapOptions);
    }

    async function moveToLocation(lat, lng){
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
        const center = new google.maps.LatLng(lat, lng);
        // using global variable:
        window.map.setZoom(12);
        window.map.panTo(center);
        const marker = new AdvancedMarkerElement({
            map: window.map,
            position: { lat: lat, lng: lng },
        });
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            console.log("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        Latitude = position.coords.latitude;
        Longitude = position.coords.longitude;
        moveToLocation(Latitude, Longitude);
        console.log(Latitude);
        console.log(Longitude);
    };

    initialize();
    getLocation();
</script>

@script
<script>
    $wire.on('get-coordinate', () => {
        if (typeof Latitude !== 'undefined' && typeof Longitude !== 'undefined' && Latitude !== null && Longitude !== null) {
            $wire.dispatch('send-coordinate', { lat: Latitude, long: Longitude });
        } else {
            alert("Latitude and Longitude are not defined.");
            location.reload();
        }
    });
</script>
@endscript
