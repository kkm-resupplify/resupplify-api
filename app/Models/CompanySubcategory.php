<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function companyProduct()
    {
        return $this->hasMany(CompanyProduct::class);
    }

    public function companyCategory()
    {
        return $this->belongsTo(CompanyCategory::class);
    }
}