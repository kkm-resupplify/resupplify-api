<?php

namespace App\Models\Product;

use App\Models\Language\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSubcategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'product_category_id'];

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class,'language_product_subcategory')->withPivot(['name']);
    }
}
