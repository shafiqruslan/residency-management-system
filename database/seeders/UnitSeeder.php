<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => 'Unit 101',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 102',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 103',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 104',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 105',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 106',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 107',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 108',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 109',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
            [
                'name' => 'Unit 110',
                'size' => '900',
                'type' => '2',
                'status' => 'available',
            ],
        ];

        foreach ($units as $unitData) {
            Unit::create($unitData);
        }
    }
}
