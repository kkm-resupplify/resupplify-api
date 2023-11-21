<?php

namespace App\Filters\Product;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ProductCategoryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return $query->whereHas('productsubcategory', function (Builder $query) use ($value) {
            $query->where('product_category_id', $value);
        });
    }
}