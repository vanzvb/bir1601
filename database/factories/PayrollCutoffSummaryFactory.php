<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

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

        // Get an existing user's individ from the users table
        $userId = User::inRandomOrder()->first()->individ;

        // Generate a random year between 2019 and the current year
        // $year = $this->faker->numberBetween(2019, 2024); // random year from 2019-2024
        $year = 2024;

        // If the year is 2024, limit the months to May
        $month = ($year == 2024) ? $this->faker->numberBetween(2, 4) : $this->faker->numberBetween(1, 12);

        // Ensure each user has one cutoff value 1 and one cutoff value 2 per month
        $cutoff = $phRowId % 2 == 0 ? 0 : 1;
        $phRowId++;

        // Ensure uniqueness per user, month, year, and cutoff
        $exists = DB::table('payroll_cutoff_summaries')->where([
            ['empID', $userId],
            ['month', $month],
            ['year', $year],
            ['cutoff', $cutoff],
        ])->exists();

        // Regenerate month, year, and cutoff if the combination already exists
        while ($exists) {
            $year = $this->faker->numberBetween(2019, 2024);
            $month = ($year == 2024) ? $this->faker->numberBetween(1, 5) : $this->faker->numberBetween(1, 12);
            $cutoff = $phRowId % 2 == 0 ? 0 : 1;
            $exists = DB::table('payroll_cutoff_summaries')->where([
                ['empID', $userId],
                ['month', $month],
                ['year', $year],
                ['cutoff', $cutoff],
            ])->exists();
        }
        
        return [
            'pSummaryID' => $this->faker->unique()->regexify('[A-Za-z0-9]{50}'),
            'dtrSummaryID' => $this->faker->unique()->regexify('[A-Za-z0-9]{200}'),
            'payslipNo' => $this->faker->unique()->regexify('[A-Za-z0-9]{50}'),
            'empID' => $userId,
            'month' => $month,
            'cutoff' => $cutoff,
            'year' => $year,
            'paydate' => $this->faker->date(),
            'period' => $this->faker->optional()->text(100),
            'basicpay' => Crypt::encrypt(
                number_format($this->faker->randomFloat(2, 0, 999999.99), 2, '.', ',')
            ),
            'semim' => $this->faker->randomNumber(5),
            'dailyrate' => $this->faker->randomNumber(5),
            'hourlyrate' => $this->faker->randomNumber(5),
            'paidvl' => $this->faker->randomNumber(5),
            'paidsl' => $this->faker->randomNumber(5),
            'paidbl' => $this->faker->randomNumber(5),
            'allowance' => $this->faker->randomNumber(5),
            'total_dmm' => Crypt::encrypt(
                number_format($this->faker->randomFloat(2, 0, 999999.99), 2, '.', ',')
            ),
            'total_premium' => Crypt::encrypt(
                number_format($this->faker->randomFloat(2, 0, 999999.99), 2, '.', ',')
            ),
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
            'total_e' => Crypt::encrypt(
                number_format($this->faker->randomFloat(2, 0, 999999.99), 2, '.', ',')
            ),
            'total_d' => Crypt::encrypt(
                number_format($this->faker->randomFloat(2, 0, 999999.99), 2, '.', ',')
            ),
            'net_p' => $this->faker->randomNumber(5),
            'taxbaseID' => $this->faker->unique()->regexify('[A-Za-z0-9]{50}'),
            'tax' => Crypt::encrypt(
                number_format($this->faker->randomFloat(2, 0, 999999.99), 2, '.', ',')
            ),
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
