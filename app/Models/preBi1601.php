<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preBi1601 extends Model
{
    use HasFactory;

    protected $table = 'pre_bi_1601';

    protected $fillable = [
        'empID', 
        'cutoff', 
        'basic_pay', 
        'total_dmm', 
        'total_premium', 
        'total_e', 
        'total_d', 
        'total_gross_pay_salary', 
        'tax'
    ];
}
