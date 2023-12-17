<?php

namespace App\Models\Company;

use App\Models\User\User;
use App\Models\Order\Order;
use App\Models\Country\Country;
use App\Models\Product\Product;
use App\Models\Product\ProductTag;
use App\Models\Product\ProductCart;
use App\Models\Warehouse\Warehouse;
use App\Models\Product\ProductOffer;
use App\Models\Company\CompanyBalance;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Models\Company\Enums\CompanyCategoryEnum;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Company extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

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

    public function invitationCodes(): HasMany
    {
        return $this->hasMany(UserInvitationCode::class);
    }

    public function users(): HasManyThrough
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

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function productTags(): HasMany
    {
        return $this->hasMany(ProductTag::class);
    }

    public function productCarts(): HasOne
    {
        return $this->hasOne(ProductCart::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function companyBalances(): HasOne
    {
        return $this->hasOne(CompanyBalance::class);
    }

    public function productOffers(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductOffer::class,
            Product::class,
            'company_id',
            'company_product_id',
            'id',
            'id'
        );
    }
}
