<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreBir1601 extends Model
{
    use HasFactory;

    protected $table = 'pre_bir_1601s';

    protected $fillable = [
        'empID', 
        'tin',
        'bouID',
        'basic_pay_first', // cutoff 1-15
        'basic_pay_second', // cutoff 16-31
        'basic_pay_total', // basic
        'premium_first', // cutoff 1-15
        'premium_second', // cutoff 16-31
        'tot_premium',  // premium
        'dmm_first', // cutoff 1-15
        'dmm_second', // cutoff 16-31
        'tot_dmm', //diminimis
        'proj_exp_first', // cutoff 1-15
        'proj_exp_second', // cutoff 16-31
        'tot_proj_exp', // (proj exp reim) total_e in payroll_cutoff_summary
        'deduction_first', // cutoff 1-15
        'deduction_second', // cutoff 16-31
        'tot_deduction', // (deduction) total_d in payroll_cutoff_summary
        'gross_pay_first', // cutoff 1-15
        'gross_pay_second', // cutoff 16-31
        'tot_gross_pay_salary', // gross pay
        'tax_first', // cutoff 1-15
        'tax_second', // cutoff 16-31
        'tot_tax', // taxable
    ];



    public function user()
    {
        // return $this->belongsTo(User::class);

        return $this->belongsTo(User::class, 'empID', 'id');

    }

    public function companyBou()
    {
        return $this->belongsTo(CompanyBou::class, 'bouID', 'id');
    }
}
