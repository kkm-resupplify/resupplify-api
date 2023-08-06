<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class CompanyRole extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'permision_level'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function companyMembers(): HasMany
    {
        return $this->hasMany(CompanyMember::class);
    }
}
