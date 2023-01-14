<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ShiftSeeder::class,
            LokasiSeeder::class,
            // StatusSeeder::class,
            UserDetailSeeder::class,
            UserCutiSeeder::class,
            CutiFormatSeeder::class,
            JabatanSeeder::class,
        ]);
    }
}