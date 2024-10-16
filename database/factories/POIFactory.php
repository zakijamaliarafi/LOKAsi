<?php

namespace Database\Factories;

use App\Models\POI;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\POI>
 */
class POIFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'location_name' => 'test payment',
            'status' => 'accepted',
            'latitude' => '7',
            'longitude' => '100',
            'image_path' => 'poi_image/',
            'input_time' => now(),
            'contributor_id' => '4',
        ];
    }

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = POI::class;
}
