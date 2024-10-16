<?php

namespace App\Models;

use Database\Factories\POIFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class POI extends Model
{
    use HasFactory, HasUlids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reports_poi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'reject_reason',
        'location_name',
        'location_info',
        'img_latitude',
        'img_longitude',
        'img_altitude',
        'img_time',
        'location_address',
        'category',
        'latitude',
        'longitude',
        'image_path',
        'input_time',
        'claim_id',
        'claim_time_start',
        'claim_time_end',
        'curate_time',
        'contributor_id',
        'curator_id',
    ];

    public function contributor()
    {
        return $this->belongsTo(User::class, 'contributor_id');
    }

    protected static function newFactory(): Factory
    {
        return POIFactory::new();
    }
}
