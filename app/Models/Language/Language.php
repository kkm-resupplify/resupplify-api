<?php

namespace App\Models\Language;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductSubcategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User\User;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'code', 'origin_name'];

    public function productCategories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function productSubcategories(): BelongsToMany
    {
        return $this->belongsToMany(ProductSubcategory::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
