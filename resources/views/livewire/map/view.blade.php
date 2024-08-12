<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Url;

new class extends Component {
    #[Url]
    public ?string $category;

    public function mount(): void
    {
        if($this->category != null){
            $this->dispatch('category-selected', $this->category);
        } 
    } 
}; ?>



<div class="h-[calc(100vh-6rem)] w-[calc(100vw-13rem)] m-2">
    <div id="map" class="h-full"></div>
</div>

<script src="{{ asset('js/config.js') }}"></script>
<script>var apikey = config.MAP_API_KEY;</script>

<!-- prettier-ignore -->
<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
    ({key: apikey, v: "weekly"});</script>

<script>
    window.addEventListener('category-selected', event => {
        var category = event.detail;
        initMap(category);
    });

    async function initMap(category) {
        const { Map } = await google.maps.importLibrary("maps");
        const map = new Map(document.getElementById("map"), {
            zoom: 12.5,
            center: { lat: -7.4124026261742895, lng: 109.23412723849769 }, 
            mapId: "DEMO_MAP_ID",
        });

        var geoJsonUrl = `/js/${category}.geojson`;
        map.data.loadGeoJson(geoJsonUrl);
    }

    initMap();
</script>
