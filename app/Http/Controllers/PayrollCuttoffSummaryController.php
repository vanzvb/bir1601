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
    public function index(Request $request)
    {
        // $users = User::all();

        // $bir1601s = bir1601::all();

        // $company_bous = CompanyBou::all();
        // $payroll_cuttoff_summaries = PayrollCutoffSummary::all();

        // $year = 2024; // Example year variable
        // $month = 4;   // Example month variable

        $year = $request->input('year', '');
        $month = $request->input('month', '');

        if ($year && $month) {

            $payroll_cuttoff_summaries = PayrollCutoffSummary::where('year', $year)
            ->where('month', $month)
            ->get([
                'year',
                'month',
                'basicpay',
                'cutoff',
                'total_dmm',
                'total_e',
                'total_d',
                'total_premium',
                'tax'
            ]);

            

            $payroll_cuttoff_summaries->map(function ($summary) {
                // Decrypt BasicPay1 for cutoff 0
                MAX(CASE WHEN $summary->cutoff = 1 THEN $summary->basicpay ELSE 0 END) AS BasicPay1');
                dd($summary);
                $summary->BasicPay1 = ($summary->cutoff == 1) ? Crypt::decrypt($summary->BasicPay) : 0;
    
                // Decrypt BasicPay2 for cutoff 1
                $summary->BasicPay2 = ($summary->cutoff == 2) ? Crypt::decrypt($summary->BasicPay) : 0;
    
                // Calculate TotalBasicPay
                $summary->TotalBasicPay = $summary->BasicPay1 + $summary->BasicPay2;
                
                
                // Repeat the same process for other fields if needed
                // Example for Premium:
                $summary->Premium1 = ($summary->cutoff == 0) ? Crypt::decrypt($summary->total_premium) : 0;
                $summary->Premium2 = ($summary->cutoff == 1) ? Crypt::decrypt($summary->total_premium) : 0;
                $summary->TotalPremium = $summary->Premium1 + $summary->Premium2;
    
                // Example for DMM:
                $summary->DMM1 = ($summary->cutoff == 0) ? Crypt::decrypt($summary->total_dmm) : 0;
                $summary->DMM2 = ($summary->cutoff == 1) ? Crypt::decrypt($summary->total_dmm) : 0;
                $summary->TotalDMM = $summary->DMM1 + $summary->DMM2;
    
                // Example for Project Expense:
                $summary->ProjExp1 = ($summary->cutoff == 0) ? Crypt::decrypt($summary->total_e) : 0;
                $summary->ProjExp2 = ($summary->cutoff == 1) ? Crypt::decrypt($summary->total_e) : 0;
                $summary->TotalProjExp = $summary->ProjExp1 + $summary->ProjExp2;
    
                // Example for Deduction:
                $summary->Deduction1 = ($summary->cutoff == 0) ? Crypt::decrypt($summary->total_d) : 0;
                $summary->Deduction2 = ($summary->cutoff == 1) ? Crypt::decrypt($summary->total_d) : 0;
                $summary->TotalDeduction = $summary->Deduction1 + $summary->Deduction2;
    
                // Example for Gross Pay Salary:
                $summary->GrossPaySal1 = ($summary->cutoff == 0) ? Crypt::decrypt($summary->total_e) : 0;
                $summary->GrossPaySal2 = ($summary->cutoff == 1) ? Crypt::decrypt($summary->total_e) : 0;
                $summary->TotalGrossPaySal = $summary->GrossPaySal1 + $summary->GrossPaySal2;
    
                // Example for Tax:
                $summary->Tax1 = ($summary->cutoff == 0) ? Crypt::decrypt($summary->tax) : 0;
                $summary->Tax2 = ($summary->cutoff == 1) ? Crypt::decrypt($summary->tax) : 0;
                $summary->TotalTax = $summary->Tax1 + $summary->Tax2;
    
                // return $summary;
            });
            dd($payroll_cuttoff_summaries);
        } else {
            $payroll_cuttoff_summaries = collect(); // Empty collection for the initial load
        }

        

        return view('payroll_cutoff_summary.payroll_cutoff_summary', compact('payroll_cuttoff_summaries','year','month'));
    }

    public function save(Request $request)
    {

        $year = $request->input('year', '');
        $month = $request->input('month', '');

        try {         
            
            // Start a transaction
            DB::beginTransaction();

            // $year = 2024; // Example year variable
            // $month = 4;   // Example month variable
        if ($year && $month) {

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
                    'basic_pay_first' => Crypt::encryptString($summary->BasicPay1),
                    'basic_pay_second' => Crypt::encryptString($summary->BasicPay2),
                    'basic_pay_total' => Crypt::encryptString($summary->TotalBasicPay),
                    'premium_first' => Crypt::encryptString($summary->Premium1),
                    'premium_second' => Crypt::encryptString($summary->Premium1),
                    'tot_premium' => Crypt::encryptString($summary->TotalPremium),
                    'dmm_first' => Crypt::encryptString($summary->DMM1),
                    'dmm_second' => Crypt::encryptString($summary->DMM2),
                    'tot_dmm' => Crypt::encryptString($summary->TotalDMM),
                    'proj_exp_first' => Crypt::encryptString($summary->ProjExp1),
                    'proj_exp_second' => Crypt::encryptString($summary->ProjExp2),
                    'tot_proj_exp' => Crypt::encryptString($summary->TotalProjExp),
                    'deduction_first' => Crypt::encryptString($summary->Deduction1),
                    'deduction_second' => Crypt::encryptString($summary->Deduction2),
                    'tot_deduction' => Crypt::encryptString($summary->TotalDeduction),
                    'gross_pay_first' => Crypt::encryptString($summary->GrossPaySal1),
                    'gross_pay_second' => Crypt::encryptString($summary->GrossPaySal2),
                    'tot_gross_pay_salary' => Crypt::encryptString($summary->TotalGrossPaySal),
                    'tax_first' => Crypt::encryptString($summary->Tax1),
                    'tax_second' => Crypt::encryptString($summary->Tax2),
                    'tot_tax' => Crypt::encryptString($summary->TotalTax)
                ]);
            }

            // Commit the transaction
            DB::commit();
        } else {
            $payroll_cuttoff_summaries = collect(); // Empty collection for the initial load
        }

            // encryption syntax 
            // 'tax' => Crypt::encryptString($summary->tax),

            return redirect()->route('payroll_cutoff_summary.payroll_cutoff_summary')->with('success', 'Payroll transfered successfully.');
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the exception for debugging purposes
            \Log::error('Error saving payroll data: ' . $e->getMessage());

            return redirect()->route('payroll_cutoff_summary.payroll_cutoff_summary')->with('error', 'An error occurred while saving the payroll data. Please try again.');
        }
    }
}
