<?php

namespace Database\Factories;

use App\Models\Jabatan;
use App\Models\Lokasi;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetail>
 */
class UserDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::query()->get()->pluck('id')->toArray();
        $jabatans = Jabatan::query()->get()->pluck('id')->toArray();
        $lokasis = Lokasi::query()->get()->pluck('id')->toArray();
        $shifts = Shift::query()->get()->pluck('id')->toArray();

        return [
            'user_id' => fake()->unique()->randomElement($users),
            'jabatan_id' => fake()->randomElement($jabatans),
            'lokasi_id' => fake()->randomElement($lokasis),
            'shift_id' => fake()->randomElement($shifts),
        ];
    }
}
