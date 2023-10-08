<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class CompanyRole extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'permission_level', 'company_id'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function companyMembers(): BelongsTo
    {
        return $this->belongsTo(CompanyMember::class);
    }
}
