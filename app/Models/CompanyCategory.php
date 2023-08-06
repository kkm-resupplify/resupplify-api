<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyCategory extends Model
{
    use HasFactory;
    public function companySubcategory(): HasMany
    {
        return $this -> hasMany(CompanySubcategory::class);
    }
    public function company(): BelongsTo
    {
        return $this -> belongsTo(Company::class);
    }
    
}
