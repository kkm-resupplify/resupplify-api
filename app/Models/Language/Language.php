<?php

namespace App\Models\Language;

use App\Models\Product\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'origin_name',
    ];

    public function productCategories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class);
    }

}
