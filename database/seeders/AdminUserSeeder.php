<?php

namespace Database\Seeders;

use App\Models\CompanyBou;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //BOU
        $bouId = CompanyBou::inRandomOrder()->first()->bouID;

        User::create([
            'name' => 'adminvanz',
            'email' => 'adminvanz@atomitsoln.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'lastName' => fake()->lastName(),
            'firstName' => fake()->firstName(),
            'middleName' => fake()->lastName(),
            'typeName' => fake()->numberBetween(1, 10),
            'roleName' => fake()->jobTitle(),
            'company' => fake()->company(),
            'jobTitle' => fake()->jobTitle(),
            'emailAdd' => fake()->unique()->safeEmail(),
            'birthDate' => fake()->date(),
            'street' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'zipCode' => fake()->postcode(),
            'language' => fake()->languageCode(),
            'timeZone' => fake()->timezone(),
            'hobbies' => fake()->word(),
            'landline' => substr(fake()->phoneNumber(), 0, 1),
            'mobile' => fake()->phoneNumber(),
            'fax' => fake()->phoneNumber(),
            'individ' => fake()->regexify('[0-9]{5}-[0-9]{5}'),
            'status' => fake()->numberBetween(0, 1),
            'biometricID' => fake()->uuid(),
            'accountType' => fake()->numberBetween(1, 3),
            'companyAccountCode' => fake()->word(),
            'isSenior' => fake()->numberBetween(0, 1),
            'isPWD' => fake()->numberBetween(0, 1),
            'lastmemo' => fake()->text(),
            'bstdate' => fake()->date(),
            'departmentID' => fake()->uuid(),
            'retailerName' => fake()->company(),
            'department' => fake()->word(),
            'emailAddref' => fake()->unique()->safeEmail(),
            'bouID' => $bouId,
            'tin' => fake()->regexify('[0-9]{3}-[0-9]{3}-[0-9]{3}-[0-9]{3}'),
        ]);
    }
}
