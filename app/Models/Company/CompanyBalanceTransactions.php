<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBalanceTransactions extends Model
{
    use HasFactory;

    public function companyBalance()
    {
        return $this->belongsTo(CompanyBalances::class);
    }
}
