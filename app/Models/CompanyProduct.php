<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProduct extends Model
{
    use HasFactory;
    public function companySubcategory(): BelongsTo
    {
        return $this -> belongsTo(CompanySubcategory::class);
    }
    public function company(): BelongsTo
    {
        return $this -> belongsTo(Company::class);
    }
}

