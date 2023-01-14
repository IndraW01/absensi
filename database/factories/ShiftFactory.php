<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fakeId = fake('id_ID');
        return [
            'name' => $fakeId->unique()->randomElement(['Libur', 'Office', 'Siang', 'Malam']),
            'slug' => fn (array $attributes) => Str::slug($attributes['name']),
            'jam_masuk' => $fakeId->unique()->randomElement(['00:00', '08:00', '13:00', '21:00']),
            'jam_keluar' => function (array $attributes) {
                if ($attributes['jam_masuk'] == '00:00') {
                    return '00:00';
                } else if ($attributes['jam_masuk'] == '08:00') {
                    return '17:00';
                } else if ($attributes['jam_masuk'] == '13:00') {
                    return '21:00';
                } else if ($attributes['jam_masuk'] == '21:00') {
                    return '07:00';
                }
            }
        ];
    }
}
