<?php

namespace App\Models\Product;

use App\Models\Company\Company;
use App\Models\Language\Language;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Models\Product\Enums\ProductVerificationStatusEnum;
use App\Models\Warehouse\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Product extends Model
{
    use HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'verification_status',
        'product_subcategory_id',
        'producer',
        'code',
        'product_unit_id',
        'company_id',
        'status',
    ];

    protected $casts = [
        'status' => ProductStatusEnum::class,
        'verification_status' => ProductVerificationStatusEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
        ->withPivot(['quantity','safe_quantity','status']);
    }

    public function productTags(): BelongsToMany
    {
        return $this->belongsToMany(ProductTag::class,'product_product_tag');
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

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class,'language_product')->withPivot(['name', 'description']);
    }
}
