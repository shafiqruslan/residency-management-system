<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::create([
            'name' => 'Futsal Court',
            'description' => '',
            'price_per_hour' => '10'
        ]);
        Facility::create([
            'name' => 'Tennis Court',
            'description' => '',
            'price_per_hour' => '10'
        ]);
        Facility::create([
            'name' => 'Pingpong Table',
            'description' => '',
            'price_per_hour' => '2'
        ]);
    }
}
