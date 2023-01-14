<?php

namespace Database\Seeders;

use App\Models\CutiFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CutiFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CutiFormat::factory()->count(1)->create();
    }
}
