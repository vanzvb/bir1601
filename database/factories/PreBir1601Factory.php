<?php

namespace Database\Factories;

use App\Models\PreBir1601;
use App\Models\User;
use App\Models\CompanyBou;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreBir1601Factory extends Factory
{
    protected $model = PreBir1601::class;

    public function definition()
    {
        $userId = User::inRandomOrder()->first()->id;
        $bouId = CompanyBou::inRandomOrder()->first()->id;

        $basicPayFirst = $this->faker->numberBetween(15000, 30000);
        $basicPaySecond = $this->faker->numberBetween(15000, 30000);
        $basicPayTotal = $basicPayFirst + $basicPaySecond;
        
        $premiumFirst = $this->faker->numberBetween(1000, 5000);
        $premiumSecond = $this->faker->numberBetween(1000, 5000);
        $totPremium = $premiumFirst + $premiumSecond;
        
        $dmmFirst = $this->faker->numberBetween(500, 2000);
        $dmmSecond = $this->faker->numberBetween(500, 2000);
        $totDmm = $dmmFirst + $dmmSecond;
        
        $projExpFirst = $this->faker->numberBetween(1000, 5000);
        $projExpSecond = $this->faker->numberBetween(1000, 5000);
        $totProjExp = $projExpFirst + $projExpSecond;
        
        $deductionFirst = $this->faker->numberBetween(1000, 5000);
        $deductionSecond = $this->faker->numberBetween(1000, 5000);
        $totDeduction = $deductionFirst + $deductionSecond;
        
        $grossPayFirst = $basicPayFirst + $premiumFirst + $dmmFirst + $projExpFirst - $deductionFirst;
        $grossPaySecond = $basicPaySecond + $premiumSecond + $dmmSecond + $projExpSecond - $deductionSecond;
        $totGrossPaySalary = $grossPayFirst + $grossPaySecond;
        
        $taxFirst = $this->faker->numberBetween(2000, 7000);
        $taxSecond = $this->faker->numberBetween(2000, 7000);
        $totTax = $taxFirst + $taxSecond;

        return [
            'empID' => $userId,
            // 'tin' => $this->faker->regexify('[0-9]{3}-[0-9]{3}-[0-9]{3}-[0-9]{3}'),
            // 'bouID' => $bouId,
            'basic_pay_first' => (string)$basicPayFirst,
            'basic_pay_second' => (string)$basicPaySecond,
            'basic_pay_total' => (string)$basicPayTotal,
            'premium_first' => (string)$premiumFirst,
            'premium_second' => (string)$premiumSecond,
            'tot_premium' => (string)$totPremium,
            'dmm_first' => (string)$dmmFirst,
            'dmm_second' => (string)$dmmSecond,
            'tot_dmm' => (string)$totDmm,
            'proj_exp_first' => (string)$projExpFirst,
            'proj_exp_second' => (string)$projExpSecond,
            'tot_proj_exp' => (string)$totProjExp,
            'deduction_first' => (string)$deductionFirst,
            'deduction_second' => (string)$deductionSecond,
            'tot_deduction' => (string)$totDeduction,
            'gross_pay_first' => (string)$grossPayFirst,
            'gross_pay_second' => (string)$grossPaySecond,
            'tot_gross_pay_salary' => (string)$totGrossPaySalary,
            'tax_first' => (string)$taxFirst,
            'tax_second' => (string)$taxSecond,
            'tot_tax' => (string)$totTax,
        ];
    }
}