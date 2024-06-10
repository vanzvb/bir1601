<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PayrollCutoffSummary>
 */
class PayrollCutoffSummaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $phRowId = 1; // Start with 1 and increment by 1 for each new record

        // Get an existing user's id from the users table
        $userId = User::inRandomOrder()->first()->id;
        
        return [
            'pSummaryID' => $this->faker->unique()->regexify('[A-Za-z0-9]{50}'),
            'dtrSummaryID' => $this->faker->unique()->regexify('[A-Za-z0-9]{200}'),
            'payslipNo' => $this->faker->unique()->regexify('[A-Za-z0-9]{50}'),
            'empID' => $userId,
            'month' => $this->faker->numberBetween(1, 12),
            'cutoff' => $this->faker->numberBetween(1, 2),
            'year' => $this->faker->numberBetween(2010, 2025),
            'paydate' => $this->faker->date(),
            'period' => $this->faker->optional()->text(100),
            'basicpay' => $this->faker->randomNumber(5),
            'semim' => $this->faker->randomNumber(5),
            'dailyrate' => $this->faker->randomNumber(5),
            'hourlyrate' => $this->faker->randomNumber(5),
            'paidvl' => $this->faker->randomNumber(5),
            'paidsl' => $this->faker->randomNumber(5),
            'paidbl' => $this->faker->randomNumber(5),
            'allowance' => $this->faker->randomNumber(5),
            'total_dmm' => $this->faker->randomNumber(5),
            'total_premium' => $this->faker->randomNumber(5),
            'total_ot' => $this->faker->randomNumber(5),
            'total_nd' => $this->faker->randomNumber(5),
            'total_ndot' => $this->faker->randomNumber(5),
            'shutdown' => $this->faker->randomNumber(5),
            'tardy' => $this->faker->randomNumber(5),
            'absent' => $this->faker->randomNumber(5),
            'ut' => $this->faker->randomNumber(5),
            'neg_snwh' => $this->faker->randomNumber(5),
            'sss' => $this->faker->randomNumber(5),
            'philhealth' => $this->faker->randomNumber(5),
            'pagibig' => $this->faker->randomNumber(5),
            'vl' => $this->faker->randomNumber(5),
            'sl' => $this->faker->randomNumber(5),
            'bl' => $this->faker->randomNumber(5),
            'total_e' => $this->faker->randomNumber(5),
            'total_d' => $this->faker->randomNumber(5),
            'net_p' => $this->faker->randomNumber(5),
            'taxbaseID' => $this->faker->unique()->regexify('[A-Za-z0-9]{50}'),
            'tax' => $this->faker->randomNumber(5),
            'adjustment_add' => $this->faker->randomNumber(5),
            'adjustment_reason' => $this->faker->optional()->regexify('[A-Za-z0-9]{50}'),
            'adjustment_minus' => $this->faker->optional()->regexify('[A-Za-z0-9]{50}'),
            'emailsent' => $this->faker->numberBetween(0, 1),
            'hasPDF' => $this->faker->numberBetween(0, 1),
            'ph_rowID' => $phRowId,
            'pi_rowID' => $phRowId,
            'net_proceeds' => $this->faker->randomNumber(5),
            'sss_rowID' => $this->faker->randomNumber(5),
            'workingDays' => $this->faker->randomFloat(2, 0, 365),
            'offset_hrs' => $this->faker->optional()->randomFloat(2, 0, 24),
            'isEdited' => $this->faker->numberBetween(0, 1),
            'hasStat' => $this->faker->numberBetween(0, 1),
            'hasDmm' => $this->faker->numberBetween(0, 1),
            'hasAllowance' => $this->faker->numberBetween(0, 1),
            'isProRated' => $this->faker->numberBetween(0, 1),
            'isOverride' => $this->faker->optional()->numberBetween(0, 1),
            'lastSentAt' => $this->faker->optional()->dateTime(),
        ];
    }
}
