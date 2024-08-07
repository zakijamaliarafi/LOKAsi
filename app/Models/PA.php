<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PA extends Model
{
    use HasFactory, HasUlids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reports_pa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'reject_reason',
        'street_name',
        'street_name_status',
        'house_number',
        'house_number_status',
        'house_number_update',
        'latitude',
        'longitude',
        'curator_id',
        'claim_id',
        'claim_time_start',
        'claim_time_end',
        'curate_time',
    ];
}
