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
            // foreach ($payroll_cuttoff_summaries as $summary) {
            //     PreBir1601::create([
            //         'empID' => $summary->empID,
            //         'basic_pay_first' => $summary->
            //     ]);
            // }

            // 'basic_pay_first', // cutoff 1-15
            // 'basic_pay_second', // cutoff 16-31
            // 'basic_pay_total', // basic

            // 'premium_first', // cutoff 1-15
            // 'premium_second', // cutoff 16-31
            // 'tot_premium',  // premium
            // 'dmm_first', // cutoff 1-15
            // 'dmm_second', // cutoff 16-31
            // 'tot_dmm', //diminimis
            // 'proj_exp_first', // cutoff 1-15
            // 'proj_exp_second', // cutoff 16-31
            // 'tot_proj_exp', // (proj exp reim) total_e in payroll_cutoff_summary
            // 'deduction_first', // cutoff 1-15
            // 'deduction_second', // cutoff 16-31
            // 'tot_deduction', // (deduction) total_d in payroll_cutoff_summary
            // 'gross_pay_first', // cutoff 1-15
            // 'gross_pay_second', // cutoff 16-31
            // 'tot_gross_pay_salary', // gross pay
            // 'tax_first', // cutoff 1-15
            // 'tax_second', // cutoff 16-31
            // 'tot_tax', // taxable

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
