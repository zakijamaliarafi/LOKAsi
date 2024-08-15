<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\ContributorMonthlyPOIReport;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $date;
    public $result;

    public function mount(): void
    {
        $this->date = Carbon::now()->format('Y-m');
        $this->getInfo();
    }

    public function updatedDate(): void
    {
        $this->getInfo();
    }

    public function getInfo(){
        $dateObj = Carbon::createFromFormat('Y-m', $this->date);
        $contributorRole = Role::where('name', 'contributor')->first();
        $this->result = DB::table('users')
        ->join('model_has_roles', function ($join) use ($contributorRole) {
            $join->on('model_has_roles.model_id', '=', 'users.id')
                 ->where('model_has_roles.role_id', $contributorRole->id)
                 ->where('model_has_roles.model_type', 'App\Models\User');
        })
        ->leftJoin('reports_poi', function ($join) use ($dateObj) {
            $join->on('users.id', '=', 'reports_poi.contributor_id')
                ->whereYear('reports_poi.input_time', $dateObj->year)
                ->whereMonth('reports_poi.input_time', $dateObj->month);
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
        $csvData = fopen('php://temp', 'r+');
        fputcsv($csvData, ['Contributor', 'Input Data', 'Accepted Data', 'Rejected Data', 'Pending Data']);
        foreach ($this->result as $data) {
            fputcsv($csvData, [$data->contributor_name, $data->total_reports, $data->accepted_count, $data->rejected_count, $data->pending_count]); 
        }
        rewind($csvData);
        $csvOutput = stream_get_contents($csvData);
        fclose($csvData);

        $csvData2 = fopen('php://temp', 'r+');
        fputcsv($csvData2, ['ID', 'Status', 'Reject Reason', 'Location Name', 'Location Address', 'Category', 'latitude', 'longitude', 'image', 'Input Time', 'Contributor', 'Curate Time', 'Curator']);
        $dateObj = Carbon::createFromFormat('Y-m', $this->date);
        $poiData = DB::table('reports_poi')
            ->leftjoin('users as curators', 'reports_poi.curator_id', '=', 'curators.id')
            ->join('users as contributors', 'reports_poi.contributor_id', '=', 'contributors.id')
            ->whereYear('reports_poi.created_at', $dateObj->year)
            ->whereMonth('reports_poi.created_at', $dateObj->month)
            ->select(
                'reports_poi.*',
                'curators.name as curator_name',
                'contributors.name as contributor_name'
            )
            ->get();
        
        foreach ($poiData as $poi) {
            fputcsv($csvData2, [$poi->id, $poi->status, $poi->reject_reason, $poi->location_name, $poi->location_address, $poi->category, $poi->latitude, $poi->longitude, $poi->image_path, $poi->input_time, $poi->contributor_name, $poi->curate_time, $poi->curator_name]); 
        }
        rewind($csvData2);
        $csvOutput2 = stream_get_contents($csvData2);
        fclose($csvData2);

        Mail::to('lokasi.terra@gmail.com')->send(new ContributorMonthlyPOIReport($csvOutput, $csvOutput2));
    }

}; ?>


<div class="mt-5">
    <div class="flex justify-between">
        <form>
            <label for="date" class="text-indigo font-semibold">Contributor Report</label>
            <input type="month" id="date" wire:model.change="date">
        </form>
        <button wire:click="send" class="inline-flex items-center justify-center px-4 py-1.5 bg-green-500 border border-transparent font-medium text-white rounded-lg tracking-widest hover:bg-green-400 hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Send Data</button>
    </div>
    <div class="bg-flash-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
        <div class="p-4 text-gray-900">
            <table class="text-left">
                <thead>
                    <tr class="text-indigo font-semibold">
                        <th class="py-1 px-2">No</th>
                        <th class="py-1 px-2">Contributor</th>
                        <th class="py-1 px-2">Total Input Data</th>
                        <th class="py-1 px-2">Total Accepted Data</th>
                        <th class="py-1 px-2">Total Rejected Data</th>
                        <th class="py-1 px-2">Total Pending Data</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!is_null($result))
                        @foreach($result as $data)
                            <tr>
                                <td class="text-indigo py-1 px-2">{{ $loop->iteration }}</td>
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