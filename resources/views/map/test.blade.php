<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="h-[40rem]">
                <div id="map" class="h-full"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/config.js') }}"></script>
    <script>var apikey = config.MAP_API_KEY;</script>

    <!-- prettier-ignore -->
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
    ({key: apikey, v: "weekly"});</script>
    
    <script>
    async function initMap() {
        const { Map } = await google.maps.importLibrary("maps");
        const { LatLng } = await google.maps.importLibrary("core");
        const { TransitLayer } = await google.maps.importLibrary("maps");

        var mapOptions = {
            zoom: 13,
            center: new LatLng(51.5, -0.11)
        }
        var map = new Map(document.getElementById("map"), mapOptions);
        var transitLayer = new TransitLayer();
        transitLayer.setMap(map);
    }
    initMap();
    </script>

</x-app-layout>