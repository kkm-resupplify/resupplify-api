<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Models\Company\Enums\CompanyCategoryEnum;

use App\Models\User\User;
use App\Models\User\UserDetails;
use App\Models\Company\CompanyCategory;
use App\Models\Company\CompanyDetails;
use App\Models\Company\CompanyProduct;
use App\Models\Company\CompanyProductDetails;
use App\Models\Company\CompanyRole;
use App\Models\Country\Country;
use App\Models\Country\CountryDetails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'country_id',
        'slug',
        'description',
        'short_description',
        'owner_id',
        'status',
    ];

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

    public function companyProducts(): HasMany
    {
        return $this->hasMany(CompanyProduct::class);
    }

    public function invitationCodes(): HasMany
    {
        return $this->hasMany(UserInvitationCode::class);
    }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            CompanyMember::class,
            'company_id',
            'id',
            'id',
            'user_id'
        );
    }
}
