<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Models\Company\Enums\CompanyCategoryEnum;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country_id', 'slug', 'description', 'owner_id', 'status'];

    protected $casts = [
        'status' => CompanyStatusEnum::class,
        'category' => CompanyCategoryEnum::class,
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function companyCategories(): HasMany
    {
        return $this->hasMany(CompanyCategory::class);
    }

    public function companyDetails(): HasOne
    {
        return $this->hasOne(CompanyDetails::class);
    }

    public function companyMembers(): HasMany
    {
        return $this->hasMany(CompanyMember::class);
    }

    public function companyRoles(): HasMany
    {
        return $this->hasMany(CompanyRole::class);
    }

    public function companyProducts(): HasMany
    {
        return $this->hasMany(CompanyProduct::class);
    }
}
