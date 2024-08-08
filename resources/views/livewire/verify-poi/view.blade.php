<?php

use App\Models\POI;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

new class extends Component {
    public POI $data;
    public $locationAddress = null;
    public $category = null;
    public $rejectReason = null;

    public function mount(): void
    {
        $this->getData();
    }

    public function getData(): void
    {
        $claimId = Session::get('current_claim_id_poi'); 
        
        if(is_null($claimId)) {
            redirect()->route('verify.poi');
        }

        $report = POI::oldest('id')
            ->where('claim_id', $claimId)
            ->where('status', 'pending')
            ->first();

        if ($report) {
            $this->data = $report;
            $this->resetForm();
        } else {
            $hasNullClaimTimeEnd = POI::whereNull('claim_time_end')
                ->where('claim_id', $claimId)
                ->exists();

            if($hasNullClaimTimeEnd) {
                POI::where('claim_id', $claimId)
                    ->update(['claim_time_end' => now()]);

                Session::forget('current_claim_id_poi');

                redirect()->route('verify.poi');
            }else{
                redirect()->route('verify.poi');
            }
        }

        $this->renderMap();
    }

    public function renderMap(): void
    {
        $this->dispatch('init-map', [
            'latitude' => $this->data->latitude,
            'longitude' => $this->data->longitude,
        ]);
    }

    public function resetForm(): void
    {
        $this->resetErrorBag();
        $this->locationAddress = null;
        $this->category = null;
        $this->rejectReason = null;
    }

    public function accept(): void
    {
        $validator = Validator::make(
            [
                'locationAddress' => $this->locationAddress,
                'category' => $this->category,
                'rejectReason' => $this->rejectReason,
            ],
            [
                'category' => 'required',
                'rejectReason' => 'prohibited',
            ],
            [
                'category.required' => 'To accept data, cetegory is required.',
                'rejectReason.prohibited' => 'To accept data, reject reason must be empty.',
            ]
        );

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            $this->renderMap();
            return;
        }

        if($this->locationAddress !== null) {
            $this->data->location_address = $this->locationAddress;
        }
        $this->data->category = $this->category;
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
    <div class="w-1/2">
        <div class="h-96 w-full bg-white">
            <form wire:submit.prevent>
                <div class="pt-5 pl-10 text-xl">
                    Report From: {{ $data->contributor->name }}
                </div>
    
                <div class="pt-2 pl-10 text-lg">
                    Location name: {{ $data->location_name }}
                </div>
    
                <div class="pt-2 pl-10 text-lg">
                    <label for="location_address" class="block">Location Address</label>
                    <input id="location_address" type="text" wire:model="LocationAddress">
                </div>
                <div class="pl-10 text-red-500">
                    @error('LocationAddress')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
    
                <div class="pl-10 pt-2 text-lg">
                    <label for="option" class="block">Category</label>
                    <select id="option" wire:model="category">
                        <option value="">none</option>
                        <option value="Accounting, Tax Preparation, Bookkeeping, and Payroll Services">Accounting, Tax Preparation, Bookkeeping, and Payroll Services</option>
                        <option value="Amusement Parks and Arcades">Amusement Parks and Arcades</option>
                        <option value="Automobile Dealers">Automobile Dealers</option>
                        <option value="Automotive Equipment Rental and Leasing">Automotive Equipment Rental and Leasing</option>
                        <option value="Automotive Parts, Accessories, and Tire Retailers">Automotive Parts, Accessories, and Tire Retailers</option>
                        <option value="Automotive Repair and Maintenance">Automotive Repair and Maintenance</option>
                        <option value="Bakeries and Tortilla Manufacturing">Bakeries and Tortilla Manufacturing</option>
                        <option value="Beer, Wine, and Liquor Retailers">Beer, Wine, and Liquor Retailers</option>
                        <option value="Beverage and Tobacco Product Manufacturing">Beverage and Tobacco Product Manufacturing</option>
                        <option value="Beverage Manufacturing">Beverage Manufacturing</option>
                        <option value="Book Retailers and News Dealers">Book Retailers and News Dealers</option>
                        <option value="Building Material and Supplies Dealers">Building Material and Supplies Dealers</option>
                        <option value="Buildings">Buildings</option>
                        <option value="Business Schools and Computer and Management Training">Business Schools and Computer and Management Training</option>
                        <option value="Business Support Services">Business Support Services</option>
                        <option value="Child Care Services">Child Care Services</option>
                        <option value="Clothing and Clothing Accessories Retailers">Clothing and Clothing Accessories Retailers</option>
                        <option value="Colleges, Universities, and Professional Schools">Colleges, Universities, and Professional Schools</option>
                        <option value="Continuing Care Retirement Communities and Assisted Living Facilities for the Elderly">Continuing Care Retirement Communities and Assisted Living Facilities for the Elderly</option>
                        <option value="Couriers and Express Delivery Services">Couriers and Express Delivery Services</option>
                        <option value="Death Care Services">Death Care Services</option>
                        <option value="Department Stores">Department Stores</option>
                        <option value="Depository Credit Intermediation">Depository Credit Intermediation</option>
                        <option value="Drinking Places (Alcoholic Beverages)">Drinking Places (Alcoholic Beverages)</option>
                        <option value="Drycleaning and Laundry Services">Drycleaning and Laundry Services</option>
                        <option value="Electric Power Generation, Transmission and Distribution">Electric Power Generation, Transmission and Distribution</option>
                        <option value="Electronics and Appliance Retailers">Electronics and Appliance Retailers</option>
                        <option value="Elementary and Secondary Schools">Elementary and Secondary Schools</option>
                        <option value="Florists">Florists</option>
                        <option value="Furniture and Home Furnishings Retailers">Furniture and Home Furnishings Retailers</option>
                        <option value="Gambling Industries">Gambling Industries</option>
                        <option value="Gasoline Stations">Gasoline Stations</option>
                        <option value="General Medical and Surgical Hospitals">General Medical and Surgical Hospitals</option>
                        <option value="Grocery and Convenience Retailers">Grocery and Convenience Retailers</option>
                        <option value="Health and Personal Care Retailers">Health and Personal Care Retailers</option>
                        <option value="Interurban and Rural Bus Transportation">Interurban and Rural Bus Transportation</option>
                        <option value="Jewelry, Luggage, and Leather Goods Retailers">Jewelry, Luggage, and Leather Goods Retailers</option>
                        <option value="Junior Colleges">Junior Colleges</option>
                        <option value="Justice, Public Order, and Safety Activities">Justice, Public Order, and Safety Activities</option>
                        <option value="Lawn and Garden Equipment and Supplies Retailers">Lawn and Garden Equipment and Supplies Retailers</option>
                        <option value="Legal Services">Legal Services</option>
                        <option value="Motion Picture and Video Industries">Motion Picture and Video Industries</option>
                        <option value="Museums, Historical Sites, and Similar Institutions">Museums, Historical Sites, and Similar Institutions</option>
                        <option value="Office Supplies, Stationery, and Gift Retailers">Office Supplies, Stationery, and Gift Retailers</option>
                        <option value="Offices of Dentists">Offices of Dentists</option>
                        <option value="Offices of Other Health Practitioners">Offices of Other Health Practitioners</option>
                        <option value="Offices of Physicians">Offices of Physicians</option>
                        <option value="Offices of Real Estate Agents and Brokers">Offices of Real Estate Agents and Brokers</option>
                        <option value="Other Amusement and Recreation Industries">Other Amusement and Recreation Industries</option>
                        <option value="Other Miscellaneous Retailers">Other Miscellaneous Retailers</option>
                        <option value="Other Motor Vehicle Dealers">Other Motor Vehicle Dealers</option>
                        <option value="Other Personal Services">Other Personal Services</option>
                        <option value="Other Schools and Instruction">Other Schools and Instruction</option>
                        <option value="Personal and Household Goods Repair and Maintenance">Personal and Household Goods Repair and Maintenance</option>
                        <option value="Personal Care Services">Personal Care Services</option>
                        <option value="Postal Service">Postal Service</option>
                        <option value="Private Households">Private Households</option>
                        <option value="Radio and Television Broadcasting Stations">Radio and Television Broadcasting Stations</option>
                        <option value="Rail Transportation">Rail Transportation</option>
                        <option value="Religious Organizations">Religious Organizations</option>
                        <option value="Restaurants and Other Eating Places">Restaurants and Other Eating Places</option>
                        <option value="Rooming and Boarding Houses, Dormitories, and Workers' Camps">Rooming and Boarding Houses, Dormitories, and Workers' Camps</option>
                        <option value="RV (Recreational Vehicle) Parks and Recreational Camps">RV (Recreational Vehicle) Parks and Recreational Camps</option>
                        <option value="Scheduled Air Transportation">Scheduled Air Transportation</option>
                        <option value="Shoe Retailers">Shoe Retailers</option>
                        <option value="Specialized Design Services">Specialized Design Services</option>
                        <option value="Specialty Food Retailers">Specialty Food Retailers</option>
                        <option value="Sporting Goods, Hobby, and Musical Instrument Retailers">Sporting Goods, Hobby, and Musical Instrument Retailers</option>
                        <option value="Taxi and Limousine Service">Taxi and Limousine Service</option>
                        <option value="Travel Arrangement and Reservation Services">Travel Arrangement and Reservation Services</option>
                        <option value="Traveler Accommodation">Traveler Accommodation</option>
                        <option value="Urban Transit Systems">Urban Transit Systems</option>
                        <option value="Used Merchandise Retailers">Used Merchandise Retailers</option>
                        <option value="Warehouse Clubs, Supercenters, and Other General Merchandise Retailers">Warehouse Clubs, Supercenters, and Other General Merchandise Retailers</option>
                        <option value="Warehousing and Storage">Warehousing and Storage</option>
                        <option value="Water, Sewage and Other Systems">Water, Sewage and Other Systems</option>
                    </select>
                </div>
                <div class="pl-10 text-red-500">
                    @error('category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pl-10 pt-2 text-lg">
                    <label for="option" class="block">Select reject reason:</label>
                    <select id="option" wire:model="rejectReason">
                        <option value="">none</option>
                        <option value="BAD QUALITY PHOTO">BAD QUALITY PHOTO</option>
                        <option value="PHOTO ROTATE MORE THAN 45°">PHOTO ROTATE MORE THAN 45°</option>
                        <option value="PHOTO TO FAR FROM OBJECT">PHOTO TO FAR FROM OBJECT</option>
                        <option value="PHOTO ONLY CAPTURE POI SIGNBOARD">PHOTO ONLY CAPTURE POI SIGNBOARD</option>
                        <option value="POI CAPTURE FROM DIGITAL SCREEN">POI CAPTURE FROM DIGITAL SCREEN</option>
                        <option value="INCORRECT POI NAME BASED ON PHOTO">INCORRECT POI NAME BASED ON PHOTO</option>
                        <option value="INCORRECT POI LOCATION">INCORRECT POI LOCATION</option>
                    </select>
                </div>
                <div class="pl-10 text-red-500">
                    @error('rejectReason')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
    
                <div class="pl-10 pt-2 text-xl">
                    <x-primary-button type="button" wire:click="accept">Accept</x-primary-button>
                    <x-secondary-button type="button" wire:click="reject">Reject</x-secondary-button>
                </div>
            </form>
        </div>

        <div class="h-56 w-full">
            <div id="map" class="h-full"></div>
        </div>

    </div>

    <div class="w-1/">
        <img class="h-[26rem]" src="{{ asset('storage/' . $data->image_path)}}" alt="">
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
