<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company\Enums\CompanyBalanceTransactionTypeEnum;

class CompanyBalanceTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_balance_id',
        'amount',
        'status',
        'type',
        'currency',
        'payment_method_id',
        'receiver_id',
        'sender_id'
    ];

    protected $casts = [
        'status' => CompanyBalanceTransactionTypeEnum::class,
        'amount' => 'float'
    ];

    public function companyBalance()
    {
        return $this->belongsTo(CompanyBalance::class);
    }
}
