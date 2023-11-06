<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parking;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parkings = [
            [
                'name' => 'Parking 101',
                'type' => 'resident',
                'status' => 'occupied',
            ],
            [
                'name' => 'Parking 102',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking 103',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking 104',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking 105',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking 106',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking 107',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking 108',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking 109',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking 110',
                'type' => 'resident',
                'status' => 'available',
            ],
            [
                'name' => 'Parking v-101',
                'type' => 'visitor',
                'status' => 'available',
            ],
            [
                'name' => 'Parking v-102',
                'type' => 'visitor',
                'status' => 'available',
            ],
            [
                'name' => 'Parking v-103',
                'type' => 'visitor',
                'status' => 'available',
            ],
        ];

        foreach ($parkings as $parkingData) {
            Parking::create($parkingData);
        }
    }
}
