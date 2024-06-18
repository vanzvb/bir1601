<?php

namespace App\Http\Controllers;

use App\Models\CompanyBou;
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
        // for testing purposes
        // $year = 2024; // Example year variable
        // $months = [4, 5, 6]; // Example array of months
        // $bouID = "BOUpzuwc";
        
        $year = $request->input('year');
        $months = $request->input('months', []); // Assuming 'months' input is an array
        $bouIDs = $request->input('bouID', []);

        $companyBOUs = CompanyBou::all(); // Retrieve all CompanyBOU records

        if ($year && !empty($months) && !empty($bouIDs)) {

            $payroll_cuttoff_summaries = PayrollCutoffSummary::with('user.companyBOU')
            ->where('year', $year)
            ->whereIn('month', $months)
            ->whereHas('user', function ($query) use ($bouIDs) {
                $query->whereIn('bouID', $bouIDs);
            })
            ->get([
                'empID',
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


            // Decrypting encrypted columns
            $decrypted_summaries = $payroll_cuttoff_summaries->map(function ($summary) {
                $summary->basicpay = Crypt::decrypt($summary->basicpay);
                $summary->total_dmm = Crypt::decrypt($summary->total_dmm);
                $summary->total_e = Crypt::decrypt($summary->total_e);
                $summary->total_d = Crypt::decrypt($summary->total_d);
                $summary->total_premium = Crypt::decrypt($summary->total_premium);
                $summary->tax = Crypt::decrypt($summary->tax);
                return $summary;
            });

            // Group by empID
            $grouped_summaries = $decrypted_summaries->groupBy('empID');

            $result = [];

            foreach ($grouped_summaries as $empID => $summaries) {
                $monthly_data = [];
        
                foreach ($summaries as $summary) {
                    $year = $summary->year;
                    $month = $summary->month;
                    $cutoff = $summary->cutoff;
        
                    if (!isset($monthly_data[$month])) {
                        $monthly_data[$month] = [
                            'empID' => $empID,
                            'year' => $year,
                            'month' => $month,
                            'basicpay0' => null,
                            'basicpay1' => null,
                            'totalBasicPay' => null,
                            'user' => $summary->user, // Include user data  
                            // Initialize other columns as needed
                        ];
                    }
        
                    if ($cutoff == 0) {
                        $monthly_data[$month]['basicpay0'] = $summary->basicpay;
                        // Add other columns as needed for cutoff 0
                    } elseif ($cutoff == 1) {
                        $monthly_data[$month]['basicpay1'] = $summary->basicpay;
                        // Add other columns as needed for cutoff 1
                    }


                // Calculate totalBasicPay
                $monthly_data[$month]['totalBasicPay'] =  $monthly_data[$month]['basicpay0'] + $monthly_data[$month]['basicpay1'];

                }
        
                foreach ($monthly_data as $data) {
                    $result[] = $data;
                }
            }
        

        // Convert $result to a collection
        $payroll_cuttoff_summaries = collect($result);

        // dd($payroll_cuttoff_summaries);

        } else {
            $payroll_cuttoff_summaries = collect(); // Empty collection for the initial load
        }

        

        return view('payroll_cutoff_summary.payroll_cutoff_summary', compact('payroll_cuttoff_summaries','year', 'companyBOUs','bouIDs','months'));
    }

    public function save(Request $request)
    {

        // $year = $request->input('year', '');
        // $month = $request->input('month', '');

        // Dump all input data for debugging
        $input = $request->all();
        // dd($input);

        $summaries = $request->input('summaries');
        
        // Check if summaries are null
        if (is_null($summaries)) {
            return redirect()->route('payroll_cutoff_summary.payroll_cutoff_summary')->with('error', 'No data to save.');
        }

        try {         
            
            // Start a transaction
            DB::beginTransaction();

            // Process each summary if not null
            foreach ($summaries as $summary) {
                // Process each summary
                $empID = $summary['empID'];
                // $bouName = $summary['bou_name'];
                $month = $summary['month'];
                $year = $summary['year'];
                $basicpay0 = $summary['basicpay0'];
                $basicpay1 = $summary['basicpay1'];
                $totalBasicPay = $summary['totalBasicPay'];
                
                // Add your processing logic here
                PreBir1601::create([
                    'empID' => $empID,
                    'month' => $month,
                    'year' => $year,
                    'basic_pay_first' => Crypt::encryptString($basicpay0),
                    'basic_pay_second' => Crypt::encryptString($basicpay1),
                    'basic_pay_total' => Crypt::encryptString($totalBasicPay)
                ]);
            }


            // Commit the transaction
            DB::commit();

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
