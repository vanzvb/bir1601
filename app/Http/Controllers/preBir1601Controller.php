<?php

namespace App\Http\Controllers;

use App\Models\CompanyBou;
use App\Models\PreBir1601;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class preBir1601Controller extends Controller
{
    public function index()
    {

        $users = User::all();

        // $bir1601s = bir1601::all();

        $company_bous = CompanyBou::all();

        return view('index_bir1601', compact('users', 'company_bous'));
    }

    public function preBir1601(Request $request)
    {
        $months = $request->input('month', []);  // Handle multiple months, default to empty array
        $year = $request->input('year');
        $bouID = $request->input('bouID', []);
    
        // Base query with required year
        $pre_bir_1601s = PreBir1601::where('year', $year);

        // If bouID is provided, add the bouID filter
        if (!empty($bouID)) {
            $pre_bir_1601s->whereHas('user', function($query) use ($bouID) {
                $query->whereIn('bouID', $bouID);
            });
        } else {
            $pre_bir_1601s->whereHas('user');
        }

        // If months are provided, add the month filter
        if (!empty($months)) {
            $pre_bir_1601s->whereIn('month', $months);
        }
    
        $pre_bir_1601s = $pre_bir_1601s->get();

        // Decrypting encrypted columns
        $decrypted_summaries = $pre_bir_1601s->map(function ($summary) {
            $summary->basic_pay_first = Crypt::decrypt($summary->basic_pay_first);
            $summary->basic_pay_second = Crypt::decrypt($summary->basic_pay_second);
            $summary->basic_pay_total = Crypt::decrypt($summary->basic_pay_total);
            $summary->premium_first = Crypt::decrypt($summary->premium_first);
            $summary->premium_second = Crypt::decrypt($summary->premium_second);
            $summary->tot_premium = Crypt::decrypt($summary->tot_premium);
            $summary->dmm_first = Crypt::decrypt($summary->dmm_first);
            $summary->dmm_second = Crypt::decrypt($summary->dmm_second);
            $summary->tot_dmm = Crypt::decrypt($summary->tot_dmm);
            $summary->proj_exp_first = Crypt::decrypt($summary->proj_exp_first);
            $summary->proj_exp_second = Crypt::decrypt($summary->proj_exp_second);
            $summary->tot_proj_exp = Crypt::decrypt($summary->tot_proj_exp);
            $summary->deduction_first = Crypt::decrypt($summary->deduction_first);
            $summary->deduction_second = Crypt::decrypt($summary->deduction_second);
            $summary->tot_deduction = Crypt::decrypt($summary->tot_deduction);
            $summary->gross_pay_first = Crypt::decrypt($summary->gross_pay_first);
            $summary->gross_pay_second = Crypt::decrypt($summary->gross_pay_second);
            $summary->tot_gross_pay_salary = Crypt::decrypt($summary->tot_gross_pay_salary);
            $summary->tax_first = Crypt::decrypt($summary->tax_first);
            $summary->tax_second = Crypt::decrypt($summary->tax_second);
            $summary->tot_tax = Crypt::decrypt($summary->tot_tax);
            return $summary;
        });

        $total_basic_pay = 0;
        $total_dmm = 0;
        $total_project_exp = 0;

        foreach ($pre_bir_1601s as $pre_bir_1601) {
            $total_basic_pay += intval($pre_bir_1601->basic_pay_total);
            $total_dmm += intval($pre_bir_1601->tot_dmm);
            $total_project_exp += intval($pre_bir_1601->tot_proj_exp);
        }
        
        return view('bir1601.bir1601_report', compact('pre_bir_1601s','months', 'year','bouID', 'total_basic_pay', 'total_dmm', 'total_project_exp'));
    }

    public function clear()
    {
        try {
            PreBir1601::truncate(); // Truncate deletes all records from the table
            return redirect()->back()->with('status', 'Data cleared successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions that occur during truncation
            return redirect()->back()->with('error', 'Failed to clear data: ' . $e->getMessage());
        }
    }
}
