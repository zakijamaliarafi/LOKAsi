<?php

use App\Models\POI;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
// use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

new class extends Component {
    use WithFileUploads;

    public $location_name;
    public $file;
    public $latitude;
    public $longitude;
    public $address;
    public $file_name;
    public $metadata;

    public function mount($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function submit()
    {
        $this->validate([
            'file' => 'required|file',
            'location_name' => 'required|string|max:255',
        ]);

        $extension = $this->file->getClientOriginalExtension();
        $currentTime = now()->format('YmdHisv');
        $this->file_name = "IMG_" . $currentTime . "." . $extension;

        $manager = new ImageManager(new Driver());
        $img = $manager->read($this->file);
        $path = 'public/poi_image/' . $this->file_name;
        $encodedImage = $img->toJpg(75);
        Storage::put($path, $encodedImage);

        $this->metadata = $this->read_image_metadata($this->file->getRealPath());
        // dd($metadata['lat'], $metadata['lng']);

        $this->dispatch('get-address', ['lat' => $this->metadata['lat'], 'lng' => $this->metadata['lng']]);
        // dd($this->address);
    }

    public function read_image_metadata($file){
        $info = exif_read_data($file);
        if (isset($info['GPSLatitude']) && isset($info['GPSLongitude']) &&
            isset($info['GPSLatitudeRef']) && isset($info['GPSLongitudeRef']) &&
            in_array($info['GPSLatitudeRef'], array('E','W','N','S')) && in_array($info['GPSLongitudeRef'], array('E','W','N','S'))) {

            $GPSLatitudeRef  = strtolower(trim($info['GPSLatitudeRef']));
            $GPSLongitudeRef = strtolower(trim($info['GPSLongitudeRef']));

            $lat_degrees_a = explode('/',$info['GPSLatitude'][0]);
            $lat_minutes_a = explode('/',$info['GPSLatitude'][1]);
            $lat_seconds_a = explode('/',$info['GPSLatitude'][2]);
            $lng_degrees_a = explode('/',$info['GPSLongitude'][0]);
            $lng_minutes_a = explode('/',$info['GPSLongitude'][1]);
            $lng_seconds_a = explode('/',$info['GPSLongitude'][2]);

            $lat_degrees = $lat_degrees_a[0] / $lat_degrees_a[1];
            $lat_minutes = $lat_minutes_a[0] / $lat_minutes_a[1];
            $lat_seconds = $lat_seconds_a[0] / $lat_seconds_a[1];
            $lng_degrees = $lng_degrees_a[0] / $lng_degrees_a[1];
            $lng_minutes = $lng_minutes_a[0] / $lng_minutes_a[1];
            $lng_seconds = $lng_seconds_a[0] / $lng_seconds_a[1];

            $lat = (float) $lat_degrees+((($lat_minutes*60)+($lat_seconds))/3600);
            $lng = (float) $lng_degrees+((($lng_minutes*60)+($lng_seconds))/3600);

            //If the latitude is South, make it negative. 
            //If the longitude is west, make it negative
            $GPSLatitudeRef  == 's' ? $lat *= -1 : '';
            $GPSLongitudeRef == 'w' ? $lng *= -1 : '';
        } else {
            $lat = null;
            $lng = null;
        }
        
        // Get altitude if available
        if (isset($info['GPSAltitude']) && isset($info['GPSAltitudeRef'])) {
            $altitude_ref = $info['GPSAltitudeRef'];
            $altitude_a = explode('/', $info['GPSAltitude']);
            $altitude = $altitude_a[0] / $altitude_a[1];

            // If altitude reference is 1, it means the altitude is below sea level, so we make it negative
            if ($altitude_ref == 1) {
                $altitude *= -1;
            }
        } else {
            $altitude = null; // Altitude not available
        }

        if (isset($info['DateTimeOriginal'])) {
            // Get the original date and time the photo was taken
            $datetime_original = $info['DateTimeOriginal'];

            // Convert it into a standard format (optional)
            $timestamp = strtotime($datetime_original);
            $formatted_time = date('Y-m-d H:i:s', $timestamp);
        } else {
            $formatted_time = null;
        }
        
        return array(
            'lat' => $lat,
            'lng' => $lng,
            'altitude' => $altitude,
            'time' => $formatted_time
        );
    }

    #[On('send-address')]
    public function set_address($address) {
        $this->address = $address;
        // dd($this->address);
        POI::create([
            'location_name' => $this->location_name,
            'location_info' => $this->address,
            'img_latitude' => $this->metadata['lat'],
            'img_longitude' => $this->metadata['lng'],
            'img_altitude' => $this->metadata['altitude'],
            'img_time' => $this->metadata['time'],
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'image_path' => "poi_image/". $this->file_name,
            'input_time' => now(),
            'contributor_id' => auth()->user()->id,
        ]);

        session()->flash('message', 'Form submitted successfully!');
        $this->reset(['location_name', 'file']);
    }
}; ?>

<div class="absolute bottom-0 left-0">
    <div class="w-screen rounded-xl bg-white">
        <form wire:submit.prevent="submit">
            <div class="flex justify-center pt-4">
                <p class="text-indigo text-xl font-semibold">Form <span class="text-black">LOKA</span><span class="text-[#FF0000]">si</span> Report</p>
            </div>
            <div class="flex justify-center pb-10">
                <div class="w-50">
                    <div class="mb-4">
                        <label for="file" class="text-indigo text-xl font-semibold">Foto</label>
                        <input type="file" id="file" capture="user" accept="image/*" wire:model="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('file') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="text" class="text-indigo text-xl font-semibold">Location Name</label>
                        <input type="text" id="text" wire:model="location_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('location_name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="bg-indigo text-white text-lg font-semibold px-2 py-2 rounded w-full">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/config.js') }}"></script>
@script
<script>
    $wire.on('get-address', (data) => {
        var lat = data[0]['lat'];
        var lng = data[0]['lng'];
        var apikey = config.MAP_API_KEY;
        // console.log(lat);
        // console.log(lng);
        // console.log(apikey);

        const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&result_type=street_address&key=${apikey}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'OK') {
                    const address = data.results[0].formatted_address;
                    // console.log('Address:', address);
                    $wire.dispatch('send-address', {address: address});
                } else {
                    console.log('Geocoding failed:', data.status);
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
@endscript
