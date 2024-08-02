<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'contributor_id',
        'input_time',
        'status',
        'curator_id',
        'claim_id',
        'claim_time_start',
        'claim_time_end',
        'curate_time',
        'curate_note',
    ];
}
