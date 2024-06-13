<?php

namespace App\Http\Controllers;

use App\Models\PayrollCutoffSummary;
use App\Models\pre_bir_1601;
use App\Models\preBi1601;
use App\Models\PreBir1601;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PayrollCuttoffSummaryController extends Controller
{
    public function index()
    {
        // $users = User::all();

        // $bir1601s = bir1601::all();

        // $company_bous = CompanyBou::all();
        // $payroll_cuttoff_summaries = PayrollCutoffSummary::all();

        $year = 2024; // Example year variable
        $month = 4;   // Example month variable

        $payroll_cuttoff_summaries = PayrollCutoffSummary::select([
            'empID',
            'year',
            'month',

            // BASIC PAY
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN BasicPay ELSE 0 END) AS BasicPay1'),
            DB::raw('MAX(CASE WHEN cutoff = 2 THEN BasicPay ELSE 0 END) AS BasicPay2'),
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN BasicPay ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN BasicPay ELSE 0 END) AS TotalBasicPay'),

            // PREMIUM
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_premium ELSE 0 END) AS Premium1'),
            DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_premium ELSE 0 END) AS Premium2'),
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_premium ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_premium ELSE 0 END) AS TotalPremium'),

            // Deminimis
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_dmm ELSE 0 END) AS DMM1'),
            DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_dmm ELSE 0 END) AS DMM2'),
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_dmm ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_dmm ELSE 0 END) AS TotalDMM'),

            // Project Expense Reim
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_e ELSE 0 END) AS ProjExp1'),
            DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_e ELSE 0 END) AS ProjExp2'),
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_e ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_e ELSE 0 END) AS TotalProjExp'),

            // Deduction
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_d ELSE 0 END) AS Deduction1'),
            DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_d ELSE 0 END) AS Deduction2'),
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_d ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_d ELSE 0 END) AS TotalDeduction'),

            // Gross Pay Salary (sample total_e) but should be redo
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_e ELSE 0 END) AS GrossPaySal1'),
            DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_e ELSE 0 END) AS GrossPaySal2'),
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_e ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_e ELSE 0 END) AS TotalGrossPaySal'),

            // Taxable
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN tax ELSE 0 END) AS Tax1'),
            DB::raw('MAX(CASE WHEN cutoff = 2 THEN tax ELSE 0 END) AS Tax2'),
            DB::raw('MAX(CASE WHEN cutoff = 1 THEN tax ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN tax ELSE 0 END) AS TotalTax'),
        ])
        ->where('year', $year)
        ->where('month', $month)
        ->groupBy('empID', 'year', 'month')
        ->get();

        return view('payroll_cutoff_summary.payroll_cutoff_summary', compact('payroll_cuttoff_summaries'));
    }

    public function save(Request $request)
    {

        try {            

            $year = 2024; // Example year variable
            $month = 4;   // Example month variable
    
            $payroll_cuttoff_summaries = PayrollCutoffSummary::select([
                'empID',
                'year',
                'month',
    
                // BASIC PAY
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN BasicPay ELSE 0 END) AS BasicPay1'),
                DB::raw('MAX(CASE WHEN cutoff = 2 THEN BasicPay ELSE 0 END) AS BasicPay2'),
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN BasicPay ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN BasicPay ELSE 0 END) AS TotalBasicPay'),
    
                // PREMIUM
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_premium ELSE 0 END) AS Premium1'),
                DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_premium ELSE 0 END) AS Premium2'),
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_premium ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_premium ELSE 0 END) AS TotalPremium'),
    
                // Deminimis
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_dmm ELSE 0 END) AS DMM1'),
                DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_dmm ELSE 0 END) AS DMM2'),
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_dmm ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_dmm ELSE 0 END) AS TotalDMM'),
    
                // Project Expense Reim
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_e ELSE 0 END) AS ProjExp1'),
                DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_e ELSE 0 END) AS ProjExp2'),
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_e ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_e ELSE 0 END) AS TotalProjExp'),
    
                // Deduction
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_d ELSE 0 END) AS Deduction1'),
                DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_d ELSE 0 END) AS Deduction2'),
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_d ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_d ELSE 0 END) AS TotalDeduction'),
    
                // Gross Pay Salary (sample total_e) but should be redo
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_e ELSE 0 END) AS GrossPaySal1'),
                DB::raw('MAX(CASE WHEN cutoff = 2 THEN total_e ELSE 0 END) AS GrossPaySal2'),
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN total_e ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN total_e ELSE 0 END) AS TotalGrossPaySal'),
    
                // Taxable
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN tax ELSE 0 END) AS Tax1'),
                DB::raw('MAX(CASE WHEN cutoff = 2 THEN tax ELSE 0 END) AS Tax2'),
                DB::raw('MAX(CASE WHEN cutoff = 1 THEN tax ELSE 0 END) + MAX(CASE WHEN cutoff = 2 THEN tax ELSE 0 END) AS TotalTax'),
            ])
            ->where('year', $year)
            ->where('month', $month)
            ->groupBy('empID', 'year', 'month')
            ->get();

            

            // Loop through each summary and save them one by one
            foreach ($payroll_cuttoff_summaries as $summary) {
                PreBir1601::create([
                    'empID' => $summary->empID,
                    'month' => $summary->month,
                    'year' => $summary->year,
                    'basic_pay_first' => $summary->BasicPay1,
                    'basic_pay_second' => $summary->BasicPay2,
                    'basic_pay_total' => $summary->TotalBasicPay,
                    'premium_first' => $summary->Premium1,
                    'premium_second' => $summary->Premium1,
                    'tot_premium' => $summary->TotalPremium,
                    'dmm_first' => $summary->DMM1,
                    'dmm_second' => $summary->DMM2,
                    'tot_dmm' => $summary->TotalDMM,
                    'proj_exp_first' => $summary->ProjExp1,
                    'proj_exp_second' => $summary->ProjExp2,
                    'tot_proj_exp' => $summary->TotalProjExp,
                    'deduction_first' => $summary->Deduction1,
                    'deduction_second' => $summary->Deduction2,
                    'tot_deduction' => $summary->TotalDeduction,
                    'gross_pay_first' => $summary->GrossPaySal1,
                    'gross_pay_second' => $summary->GrossPaySal2,
                    'tot_gross_pay_salary' => $summary->TotalGrossPaySal,
                    'tax_first' => $summary->Tax1,
                    'tax_second' => $summary->Tax2,
                    'tot_tax' => $summary->TotalTax
                ]);
            }

            // encryption syntax 
            // 'tax' => Crypt::encryptString($summary->tax),

            return redirect()->route('payroll_cutoff_summary.payroll_cutoff_summary')->with('success', 'Payroll transfered successfully.');
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            \Log::error('Error saving payroll data: ' . $e->getMessage());

            return redirect()->route('payroll_cutoff_summary.payroll_cutoff_summary')->with('error', 'An error occurred while saving the payroll data. Please try again.');
        }
    }
}
