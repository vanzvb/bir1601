<?php

namespace App\Http\Controllers;

use App\Models\PayrollCutoffSummary;
use App\Models\pre_bir_1601;
use App\Models\preBi1601;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PayrollCuttoffSummaryController extends Controller
{
    public function index()
    {
        // $users = User::all();

        // $bir1601s = bir1601::all();

        // $company_bous = CompanyBou::all();
        $payroll_cuttoff_summaries = PayrollCutoffSummary::all();

        return view('payroll_cutoff_summary.payroll_cutoff_summary', compact('payroll_cuttoff_summaries'));
    }

    public function save(Request $request)
    {

        $request->validate([
            'empID' => 'required',
            'cutoff' => 'required',
            'basic_pay' => 'required',
            'total_dmm' => 'required',
            'total_premium' => 'required',
            'total_e' => 'required',
            'total_d' => 'required',
            'total_gross_pay_salary' => 'required', // need to update
            'tax' => 'required'
        ]);

        // gets all the request
        // dd($request->all());

        try {
            // will only save page 1 of pagination data
            // for ($i = 0; $i < count($request->empID); $i++) {
            //     preBi1601::create([
            //         'empID' => $request->empID[$i],
            //         'cutoff' => $request->cutoff[$i],
            //         'basic_pay' => $request->basic_pay[$i],
            //         'total_dmm' => $request->total_dmm[$i],
            //         'total_premium' => $request->total_premium[$i],
            //         'total_e' => $request->total_e[$i],
            //         'total_d' => $request->total_d[$i],
            //         'total_gross_pay_salary' => $request->total_gross_pay_salary[$i],
            //         'tax' => $request->tax[$i],
            //         '_token' => $request->_token,
            //     ]);
            // }
            
            // Fetch all payroll cutoff summaries
            // just filter here incase (theres a filter)
            $payroll_cuttoff_summaries = PayrollCutoffSummary::all();
            
            // Loop through each summary and save them one by one
            foreach ($payroll_cuttoff_summaries as $summary) {
                pre_bir_1601::create([
                    'empID' => $summary->empID,
                    'cutoff' => $summary->cutoff,
                    'basic_pay' => Crypt::encryptString($summary->basicpay),
                    'total_dmm' => Crypt::encryptString($summary->total_dmm),
                    'total_premium' => Crypt::encryptString($summary->total_premium),
                    'total_e' => Crypt::encryptString($summary->total_e),
                    'total_d' => Crypt::encryptString($summary->total_d),
                    'total_gross_pay_salary' => Crypt::encryptString($summary->basicpay), // need to update, should be total_gross_pay_salary
                    'tax' => Crypt::encryptString($summary->tax),
                    '_token' => $request->_token,
                ]);
            }

            return redirect()->route('payroll_cutoff_summary.payroll_cutoff_summary')->with('success', 'Payroll transfered successfully.');
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            \Log::error('Error saving payroll data: ' . $e->getMessage());

            return redirect()->route('payroll_cutoff_summary.payroll_cutoff_summary')->with('error', 'An error occurred while saving the payroll data. Please try again.');
        }
    }
}
