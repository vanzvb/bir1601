<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\bir1601>
 */
class bir1601Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get an existing user's id from the users table
        $userId = User::inRandomOrder()->first()->id;

        return [
            'empID' => $userId,
            'cutoff' => $this->faker->numberBetween(0, 1),
            'basic_pay' => $this->faker->randomFloat(2, 0, 10000),
            'total_premium' => $this->faker->randomFloat(2, 0, 10000),
            'total_dmm' => $this->faker->randomFloat(2, 0, 10000),
            'total_e' => $this->faker->randomFloat(2, 0, 10000),
            'total_d' => $this->faker->randomFloat(2, 0, 10000),
            'total_gross_pay_salary' => $this->faker->randomFloat(2, 0, 10000),
            'tax' => $this->faker->randomFloat(2, 0, 10000),
        ];
    }
}
