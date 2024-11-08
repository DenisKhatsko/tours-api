<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'is_public' => fake()->boolean(),
            'name' => fake()->text(20),
            'number_of_days' => rand(1, 10),
            'description' => fake()->text(100),

        ];
    }
}
