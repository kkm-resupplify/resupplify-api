<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanySubcategory extends Model
{
    use HasFactory;
    public function companyProduct(): HasMany
    {
        return $this -> hasMany(CompanyProduct::class);
    }
}
