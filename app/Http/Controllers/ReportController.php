<?php

namespace App\Http\Controllers;

use App\Models\bir1601;
use App\Models\pre_bir_1601;
use App\Models\PreBir1601;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $bouID = $request->input('bouID');

        // dd($request);

        $total_basic = 0;
        $total_premium = 0;
        $total_dmm = 0;
        $total_expense = 0; //total_e
        $total_deduction = 0; //total_d
        $total_gross_pay_salary = 0;
        $tax = 0;

        $users = User::all();

        $bir1601s = bir1601::all();

        dd($bir1601s);

        foreach ($bir1601s as $bir1601) {
            
            $total_basic = $total_basic + $bir1601->basic_pay; // A
            $total_premium = $total_premium + $bir1601->total_premium; // B
            $total_expense = $total_expense + $bir1601->total_e; // C

        }

        // Pass the parameters to the view
        return view('reports.bir1601', compact('month', 'year','users', 'bir1601s', 'total_basic', 'total_premium', 'total_expense', 'bouID'));

    }

    public function showReportPlus(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $bouID = $request->input('bouID');
        
        $users = User::all();

        $bir1601s = bir1601::all();

        $total_basic = 0;
        $total_premium = 0;
        $total_dmm = 0;
        $total_expense = 0; //total_e
        $total_deduction = 0; //total_d
        $total_gross_pay_salary = 0;
        $tax = 0;

        $users = User::all();

        $bir1601s = bir1601::all();

        foreach ($bir1601s as $bir1601) {
            
            $total_basic = $total_basic + $bir1601->basic_pay; // A
            $total_premium = $total_premium + $bir1601->total_premium; // B
            $total_expense = $total_expense + $bir1601->total_e; // C

        }

        // Pass the parameters to the view
        return view('reports.bir1601plus', compact('month', 'year','users', 'bir1601s', 'total_basic', 'total_premium', 'total_expense', 'bouID'));
    }

    public function test()
    {
        $bir1601s = bir1601::all();
        return view('test.index', compact('bir1601s'));
    }

    public function preBir1601(Request $request)
    {
        $months = $request->input('month', []);  // Handle multiple months, default to empty array
        $year = $request->input('year');
        $bouID = $request->input('bouID', []);
    
        // Base query with required year
        $pre_bir_1601s = PreBir1601::where('year', $year)
            ->whereHas('user', function($query) use ($bouID) {
                $query->whereIn('bouID', $bouID);
            });
    
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
            // $summary->total_e = Crypt::decrypt($summary->total_e);
            // $summary->total_d = Crypt::decrypt($summary->total_d);
            // $summary->total_premium = Crypt::decrypt($summary->total_premium);
            // $summary->tax = Crypt::decrypt($summary->tax);
            // dd($summary);
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
        
        return view('test.encryptedbir', compact('pre_bir_1601s','months', 'year','bouID', 'total_basic_pay', 'total_dmm', 'total_project_exp'));
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