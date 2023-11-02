<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

use App\Models\Product\ProductSubcategory;
use App\Models\Product\Product;

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
}
