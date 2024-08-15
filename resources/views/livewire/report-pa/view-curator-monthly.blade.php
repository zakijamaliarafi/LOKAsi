<?php

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
        $curatorRole = Role::where('name', 'curator')->first();
        $this->result = DB::table('users')
        ->join('model_has_roles', function ($join) use ($curatorRole) {
            $join->on('model_has_roles.model_id', '=', 'users.id')
                 ->where('model_has_roles.role_id', $curatorRole->id)
                 ->where('model_has_roles.model_type', 'App\Models\User');
        })
        ->leftJoin('reports_pa', function ($join) use ($dateObj) {
            $join->on('users.id', '=', 'reports_pa.curator_id')
                ->whereYear('reports_pa.curate_time', $dateObj->year)
                ->whereMonth('reports_pa.curate_time', $dateObj->month);
        })
        ->select(
            'users.id as curator_id',
            'users.name as curator_name',
            DB::raw('COALESCE(SUM(CASE WHEN reports_pa.status = "accepted" THEN 1 ELSE 0 END), 0) as accepted_count'),
            DB::raw('COALESCE(SUM(CASE WHEN reports_pa.status = "rejected" THEN 1 ELSE 0 END), 0) as rejected_count')
        )
        ->groupBy('users.id', 'users.name')
        ->get();
        // dd($this->result);
    }

}; ?>


<div class="mt-5">
    <form>
        <label for="date" class="text-indigo font-semibold">Curator Report</label>
        <input type="month" id="date" wire:model.change="date">
    </form>
    <div class="bg-flash-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
        <div class="p-4 text-gray-900">
            <table class="text-left">
                <thead>
                    <tr class="text-indigo font-semibold">
                        <th class="py-1 px-2">No</th>
                        <th class="py-1 px-2">Curator</th>
                        <th class="py-1 px-2">Total Accepted Data</th>
                        <th class="py-1 px-2">Total Rejected Data</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!is_null($result))
                        @foreach($result as $data)
                            <tr>
                                <td class="text-indigo py-1 px-2">{{ $loop->iteration }}</td>
                                <td class="text-indigo py-1 px-2">{{ $data->curator_name }}</td>
                                <td class="text-green-700 py-1 px-2 text-center">{{ $data->accepted_count }}</td>
                                <td class="text-red-700 py-1 px-2 text-center">{{ $data->rejected_count }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>