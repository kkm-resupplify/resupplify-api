<?php

namespace App\Models\Product;


use App\Models\Language\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'slug'];

    public function productSubcategories(): HasMany
    {
        return $this->hasMany(ProductSubcategory::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, ProductSubcategory::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class,'language_product_category')->withPivot(['name']);
    }
}
