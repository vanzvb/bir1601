<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/reports/bir1601', [App\Http\Controllers\ReportController::class, 'showReport'])->name('reports.bir1601');
Route::get('/reports/bir1601plus', [App\Http\Controllers\ReportController::class, 'showReportPlus'])->name('reports.bir1601plus');

Route::get('/test/index', [App\Http\Controllers\ReportController::class, 'test'])->name('test.index');

// Payroll Cutoff
Route::get('/payroll-cuttof-summary', [App\Http\Controllers\PayrollCuttoffSummaryController::class, 'index'])->name('payroll_cutoff_summary.payroll_cutoff_summary');
Route::post('/save/payroll', [App\Http\Controllers\PayrollCuttoffSummaryController::class, 'save'])->name('save.payroll');

// generate1601