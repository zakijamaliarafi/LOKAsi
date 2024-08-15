<?php

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

}; ?>


<div class="mt-5">
    <form>
        <label for="date" class="text-indigo font-semibold">Contributor Report</label>
        <input type="date" id="date" wire:model.change="date">
    </form>
    <div class="bg-flash-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
        <div class="p-4 text-gray-900">
            <table class="text-left">
                <thead>
                    <tr class="text-indigo font-semibold">
                        <th class="py-1 px-2">No</th>
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
