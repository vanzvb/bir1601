<?php

namespace Database\Factories;

use App\Models\CompanyBou;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //BOU
        $bouId = CompanyBou::inRandomOrder()->first()->id;

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

            // prod
            'lastName' => $this->faker->lastName,
            'firstName' => $this->faker->firstName,
            'middleName' => $this->faker->lastName,
            'typeName' => $this->faker->numberBetween(1, 10),
            'roleName' => $this->faker->jobTitle,
            'company' => $this->faker->company,
            'jobTitle' => $this->faker->jobTitle,
            'emailAdd' => $this->faker->unique()->safeEmail,
            'birthDate' => $this->faker->date(),
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'zipCode' => $this->faker->postcode,
            'language' => $this->faker->languageCode,
            'timeZone' => $this->faker->timezone,
            'hobbies' => $this->faker->word,
            'landline' => substr($this->faker->phoneNumber, 0, 1),
            'mobile' => $this->faker->phoneNumber,
            'fax' => $this->faker->phoneNumber,
            'individ' => $this->faker->regexify('[0-9]{5}-[0-9]{5}'),
            'status' => $this->faker->numberBetween(0, 1),
            'biometricID' => $this->faker->uuid,
            'accountType' => $this->faker->numberBetween(1, 3),
            'companyAccountCode' => $this->faker->word,
            'isSenior' => $this->faker->numberBetween(0, 1),
            'isPWD' => $this->faker->numberBetween(0, 1),
            'lastmemo' => $this->faker->text,
            'bstdate' => $this->faker->date(),
            'departmentID' => $this->faker->uuid,
            'retailerName' => $this->faker->company,
            'department' => $this->faker->word,
            'emailAddref' => $this->faker->unique()->safeEmail,
            'bouID' => $bouId,
            'tin' => $this->faker->regexify('[0-9]{3}-[0-9]{3}-[0-9]{3}-[0-9]{3}'),
            //
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
