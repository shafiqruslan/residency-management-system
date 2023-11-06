<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'identification_number' => $this->faker->individualIdentificationNumber,
            'date_of_birth' => $this->faker->dat,
            'avatar' => 'user-images/40EStZtbzLAmX9oCPNnO7BMLW9OqDD-metaZGVza3RvcC5wbmc=-.png', // You can use a default avatar or generate random image names.
        ];
    }
}
