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


// sample test
Route::get('/test/index', [App\Http\Controllers\ReportController::class, 'test'])->name('test.index');
Route::get('/test/view-bir', [App\Http\Controllers\ReportController::class, 'preBir1601'])->name('test.encryptedbir');

// Payroll Cutoff
Route::get('/payroll-cuttof-summary', [App\Http\Controllers\PayrollCuttoffSummaryController::class, 'index'])->name('payroll_cutoff_summary.payroll_cutoff_summary');

// generate1601
Route::post('/save/payroll', [App\Http\Controllers\PayrollCuttoffSummaryController::class, 'save'])->name('save.payroll');

// clear pre_bir_1601s

Route::post('/clear-pre-bir-1601s', [App\Http\Controllers\ReportController::class, 'clear'])->name('clear.pre_bir_1601s');
