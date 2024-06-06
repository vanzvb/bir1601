<?php

namespace App\Http\Controllers;

use App\Models\bir1601;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $users = User::all();

        $bir1601s = bir1601::all();

        // Pass the parameters to the view
        return view('reports.bir1601', compact('month', 'year','users', 'bir1601s'));

    }

    public function showReportPlus(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $users = User::all();

        $bir1601s = bir1601::all();

        // Pass the parameters to the view
        return view('reports.bir1601plus', compact('month', 'year','users', 'bir1601s'));
    }
}
