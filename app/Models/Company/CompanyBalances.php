<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyBalances extends Model
{
    use HasFactory;
    protected $primaryKey = 'company_id';
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        ];

    public function belongsTo(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function hasMany(): HasMany
    {
        return $this->hasMany(CompanyBalanceTransactions::class);
    }

}
