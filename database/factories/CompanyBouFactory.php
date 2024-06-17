<?php

namespace Database\Factories;

use App\Models\CompanyBou;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyBou>
 */
class CompanyBouFactory extends Factory
{

    protected $model = CompanyBou::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bouID' => $this->faker->unique()->lexify('BOU?????'),
            'bouName' => $this->faker->unique()->randomElement([
                'ABC Tech Solutions',
                'Creative Minds Studio',
                'Global Network Services',
                'Innovative Concepts Group',
                'Precision Builders Inc.',
                'Gourmet Delights Catering',
                'Sunset Properties',
                'Blue Sky Advisory',
                'Golden Gate Developers',
                'Summit Marketing',
                'Pioneer Logistics',
                'Eagle Eye Security',
                'Vivid Media Productions',
                // Add more diverse names here
            ]),
            'companyID' => $this->faker->unique()->lexify('COMP?????'),
            'isDefault' => $this->faker->boolean(10), // 10% chance of being the default
            'manager' => $this->faker->name,
            'manager_email' => $this->faker->unique()->safeEmail,
        ];
    }
}