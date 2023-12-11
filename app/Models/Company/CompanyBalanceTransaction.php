<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company\Enums\CompanyBalanceTransactionEnum;

class CompanyBalanceTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'amount',
        'status'
    ];

    protected $cast = [
        'status' => CompanyBalanceTransactionEnum::class,
    ];

    public function companyBalance()
    {
        return $this->belongsTo(CompanyBalance::class);
    }
}
