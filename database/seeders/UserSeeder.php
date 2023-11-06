<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory()
        ->count(10)
        ->sequence(fn (Sequence $sequence) => ['name' => 'Name '.$sequence->index])
        ->create();
    }
}
