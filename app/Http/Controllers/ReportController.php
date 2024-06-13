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
        $month = $request->input('month');
        $year = $request->input('year');
        $bouID = $request->input('bouID');

        $pre_bir_1601s = PreBir1601::all();

        // foreach ($pre_bir_1601s as $pre_bir_1601) {
            // Decrypt the encrypted fields
            // $pre_bir_1601->basic_pay = Crypt::decryptString($pre_bir_1601->basic_pay);
            // $pre_bir_1601->total_premium = Crypt::decryptString($pre_bir_1601->total_premium);
            // $pre_bir_1601->total_dmm = Crypt::decryptString($pre_bir_1601->total_dmm);
            // $pre_bir_1601->total_e = Crypt::decryptString($pre_bir_1601->total_e);
            // $pre_bir_1601->total_d = Crypt::decryptString($pre_bir_1601->total_d);
            // $pre_bir_1601->total_gross_pay_salary = Crypt::decryptString($pre_bir_1601->total_gross_pay_salary);
            // $pre_bir_1601->tax = Crypt::decryptString($pre_bir_1601->tax);
        // }

        $total_basic_pay = 0;
        $total_dmm = 0;
        $total_project_exp = 0;

        foreach ($pre_bir_1601s as $pre_bir_1601) {
            $total_basic_pay += intval($pre_bir_1601->basic_pay_total);
            $total_dmm += intval($pre_bir_1601->tot_dmm);
            $total_project_exp += intval($pre_bir_1601->tot_proj_exp);
        }
        
        return view('test.encryptedbir', compact('pre_bir_1601s','month', 'year','bouID', 'total_basic_pay', 'total_dmm', 'total_project_exp'));
    }
}