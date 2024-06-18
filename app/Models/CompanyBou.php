<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBou extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class, 'bouID', 'bouID');
    }

    public function companyBous()
    {
        return $this->hasMany(CompanyBou::class, 'bouID', 'bouID');
    }
}
