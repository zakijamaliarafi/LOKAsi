<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\ContributorDailyPOIReport;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $date;
    public $result;

    public function mount(): void
    {
        $this->date = Carbon::now()->toDateString();
        $this->getInfo();
    }

    public function updatedDate(): void
    {
        $this->getInfo();
    }

    public function getInfo(){
        $dateObj = $this->date;
        $contributorRole = Role::where('name', 'contributor')->first();
        $this->result = DB::table('users')
        ->join('model_has_roles', function ($join) use ($contributorRole) {
            $join->on('model_has_roles.model_id', '=', 'users.id')
                 ->where('model_has_roles.role_id', $contributorRole->id)
                 ->where('model_has_roles.model_type', 'App\Models\User');
        })
        ->leftJoin('reports_poi', function ($join) use ($dateObj) {
            $join->on('users.id', '=', 'reports_poi.contributor_id')
                 ->whereDate('reports_poi.input_time', $dateObj);
        })
        ->select(
            'users.id as contributor_id',
            'users.name as contributor_name',
            DB::raw('COALESCE(COUNT(reports_poi.id), 0) as total_reports'),
            DB::raw('COALESCE(SUM(CASE WHEN reports_poi.status = "accepted" THEN 1 ELSE 0 END), 0) as accepted_count'),
            DB::raw('COALESCE(SUM(CASE WHEN reports_poi.status = "rejected" THEN 1 ELSE 0 END), 0) as rejected_count'),
            DB::raw('COALESCE(SUM(CASE WHEN reports_poi.status = "pending" THEN 1 ELSE 0 END), 0) as pending_count'),
        )
        ->groupBy('users.id', 'users.name')
        ->get();
        // dd($this->result);
    }
    public function send(){
        $dateObj = $this->date;
        // dd($dateObj);
        $csvData = fopen('php://temp', 'r+');
        fputcsv($csvData, ['Contributor', 'Input Data', 'Accepted Data', 'Rejected Data', 'Pending Data']);
        foreach ($this->result as $data) {
            fputcsv($csvData, [$data->contributor_name, $data->total_reports, $data->accepted_count, $data->rejected_count, $data->pending_count]); 
        }
        rewind($csvData);
        $csvOutput = stream_get_contents($csvData);
        fclose($csvData);

        $csvData2 = fopen('php://temp', 'r+');
        fputcsv($csvData2, ['ID', 'Status', 'Reject Reason', 'Location Info', 'Location Name', 'Location Name Update', 'Street Name', 'Building Number', 'Category', 'latitude', 'longitude', 'image', 'image latitude', 'image longitude', 'image altitude', 'image time', 'Input Time', 'new latitude', 'new longitude', 'Claim ID', 'Claim Time Start', 'Claim Time End', 'Curate Time', 'Contributor', 'Curator']);
        $poiData = DB::table('reports_poi')
            ->leftjoin('users as curators', 'reports_poi.curator_id', '=', 'curators.id')
            ->join('users as contributors', 'reports_poi.contributor_id', '=', 'contributors.id')
            ->select(
                'reports_poi.*',
                'curators.name as curator_name',
                'contributors.name as contributor_name'
            )
            ->whereDate('reports_poi.input_time', $dateObj)
            ->get();
        
        foreach ($poiData as $poi) {
            fputcsv($csvData2, [$poi->id, $poi->status, $poi->reject_reason, $poi->location_info, $poi->location_name, $poi->location_name_update,  $poi->street_name, $poi->building_number, $poi->category, $poi->latitude, $poi->longitude, $poi->image_path, $poi->img_latitude, $poi->img_longitude, $poi->img_altitude, $poi->img_time, $poi->input_time, $poi->new_latitude, $poi->new_longitude, $poi->claim_id, $poi->claim_time_start, $poi->claim_time_end, $poi->curate_time, $poi->contributor_name, $poi->curator_name]); 
        }
        rewind($csvData2);
        $csvOutput2 = stream_get_contents($csvData2);
        fclose($csvData2);

        Mail::to('lokasi.terra@gmail.com')->send(new ContributorDailyPOIReport($csvOutput, $csvOutput2, $dateObj));

        // Record the date when the mail report is sent
        DB::table('mail_reports')->insert([
            'coordinator_id' => Auth::id(),
            'report_type' => 'Contributor Daily POI Report',
            'sent_at' => now(),
        ]);
    }

}; ?>


<div class="mt-5">
    <div class="flex justify-between">
        <form>
            <label for="date" class="text-indigo font-semibold">Contributor Report</label>
            <input type="date" id="date" wire:model.change="date">
        </form>
        <button wire:click="send" class="inline-flex items-center justify-center px-4 py-1.5 bg-green-500 border border-transparent font-medium text-white rounded-lg tracking-widest hover:bg-green-400 hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Send Data</button>
    </div>
    <div class=" overflow-hidden shadow-sm sm:rounded-lg mt-2">
        <div class="px-0 text-gray-900">
            <table class="text-left border-separate border-spacing-x-0 border-spacing-y-2">
                <thead>
                    <tr class="text-indigo font-semibold bg-flash-white">
                        <th class="py-1 px-2 pl-5">No</th>
                        <th class="py-1 px-2">Contributor</th>
                        <th class="py-1 px-2">Input Data</th>
                        <th class="py-1 px-2">Accepted Data</th>
                        <th class="py-1 px-2">Rejected Data</th>
                        <th class="py-1 px-2">Pending Data</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!is_null($result))
                        @foreach($result as $data)
                            <tr class="bg-white shadow-md">
                                <td class="text-indigo py-1 px-2 pl-5">{{ $loop->iteration }}</td>
                                <td class="text-indigo py-1 px-2">{{ $data->contributor_name }}</td>
                                <td class="text-indigo py-1 px-2 text-center">{{ $data->total_reports }}</td>
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
</div>
