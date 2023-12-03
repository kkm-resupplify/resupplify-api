<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Company\CompanyBalanceTransactions;
class CompanyBalances extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'balance'
        ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function companyBalanceTransactions(): HasMany
    {
        return $this->hasMany(CompanyBalanceTransactions::class);
    }

}
