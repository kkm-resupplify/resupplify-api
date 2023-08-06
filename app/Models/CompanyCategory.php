<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    use HasFactory;

    public function companySubcategories()
    {
        $this -> hasMany(CompanyCategory::class);
    }
}
