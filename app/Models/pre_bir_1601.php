<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pre_bir_1601 extends Model
{
    use HasFactory;

    protected $table = 'pre_bir_1601s';

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

    public function user()
    {
        // return $this->belongsTo(User::class);

        return $this->belongsTo(User::class, 'empID', 'id');

    }
}
