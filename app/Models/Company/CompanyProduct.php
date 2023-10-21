<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyProduct extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function companySubcategory(): BelongsTo
    {
        return $this->belongsTo(CompanySubcategory::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    
    public function companyProductDetails(): HasOne
    {
        return $this->hasOne(CompanyProductDetails::class);
    }
}
