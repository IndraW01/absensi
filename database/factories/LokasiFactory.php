<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lokasi>
 */
class LokasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->randomElement(['SatNetCom']),
            'slug' => fn (array $attributes) => Str::slug($attributes['name']),
            'latitude_kantor' => '-1.2468051',
            'longitude_kantor' => '116.8757698',
            'radius' => 200
        ];
    }
}
