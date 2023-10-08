<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyMember extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_id', 'company_role_id'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function companyRole(): BelongsTo
    {
        return $this->belongsTo(CompanyRole::class);
    }
}
