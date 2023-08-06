<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function companyCategories(): HasMany
    {
        return $this->hasMany(CompanyCategory::class);
    }

    public function companySubcategories(): HasManyThrough
    {
        return $this->hasManyThrough(CompanySubcategory::class, CompanyCategory::class);
    }

    public function companyProducts(): HasMany
    {
        return $this->hasMany(CompanyProduct::class);
    }

    public function companyMembers(): HasMany
    {
        return $this->hasMany(CompanyMember::class);
    }

    public function owner(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
