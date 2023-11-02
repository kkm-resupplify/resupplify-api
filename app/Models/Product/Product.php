<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Company\Company;
use App\Models\Product\ProductTag;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductSubcategory;
use App\Models\Product\ProductUnit;
use App\Models\Product\ProductImage;

use App\Models\Product\Enums\ProductStatusEnum;
use App\Models\Product\Enums\ProductVerificationStatusEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status',
        'verification_status',
        'product_subcategory_id',
    ];

    protected $casts = [
        'status' => ProductStatusEnum::class,
        'verification_status' => ProductVerificationStatusEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function productTags(): BelongsToMany
    {
        return $this->belongsToMany(ProductTag::class);
    }

    public function productSubcategory(): BelongsTo
    {
        return $this->belongsTo(ProductSubcategory::class);
    }

    public function productCategory(): HasOneThrough
    {
        return $this->hasOneThrough(
            ProductCategory::class,
            ProductSubcategory::class
        );
    }

    public function productUnit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}
