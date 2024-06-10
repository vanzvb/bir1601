<?php

namespace App\Http\Controllers;

use App\Models\bir1601;
use App\Models\CompanyBou;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $users = User::all();

        $bir1601s = bir1601::all();

        $company_bous = CompanyBou::all();

        return view('home', compact('users', 'bir1601s', 'company_bous'));
    }
}
