<?php

namespace Database\Factories;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserCuti>
 */
class UserCutiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userDetails = UserDetail::query()->get()->pluck('id')->toArray();

        return [
            'user_detail_id' => fake()->unique()->randomElement($userDetails),
            'cuti' => 10,
            'cuti_bersama' => 10,
            'cuti_menikah' => 10,
            'cuti_melahirkan' => 10,
        ];
    }
}
