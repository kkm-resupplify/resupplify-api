<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LanguageProduct extends Pivot
{
    protected $table = 'language_product';
    protected $fillable = [
        'product_id',
        'language_id',
        'name',
        'description',
    ];
}
