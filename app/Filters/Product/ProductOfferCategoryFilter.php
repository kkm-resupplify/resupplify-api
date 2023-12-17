<?php

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ProductOfferCategoryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return $query->whereHas('product.productsubcategory', function (Builder $query) use ($value) {
            $query->where('product_category_id', $value);
        });
    }
}
