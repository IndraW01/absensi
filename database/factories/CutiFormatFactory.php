<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CutiFormat>
 */
class CutiFormatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cuti' => 10,
            'cuti_bersama' => 10,
            'cuti_menikah' => 10,
            'cuti_melahirkan' => 10,
        ];
    }
}
