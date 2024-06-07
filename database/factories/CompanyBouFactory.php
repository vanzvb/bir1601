<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyBou>
 */
class CompanyBouFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bouID' => $this->faker->unique()->lexify('BOU?????'),
            'bouName' => $this->faker->words(3, true),
            'companyID' => $this->faker->unique()->lexify('COMP?????'),
            'isDefault' => $this->faker->boolean(10), // 10% chance of being the default
            'manager' => $this->faker->name,
            'manager_email' => $this->faker->unique()->safeEmail,
        ];
    }
}