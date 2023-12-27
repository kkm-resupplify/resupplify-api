<?php

namespace App\Filters\Order;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\Filters\Filter;

class OrderProductCategoryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->whereHas('productOffers', function (Builder $query) use ($value) {
            $query->whereHas('product', function (Builder $query) use ($value) {
                return $query->whereHas('productSubcategory', function (Builder $query) use ($value) {
                    $query->where('product_category_id', $value);
                });
            });
        });
    }
}
