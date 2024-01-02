<?php

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\Filters\Filter;

class ProductOfferNameFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $language_id = app('authUser')->language_id ?? 1;

        return $query->whereHas('product.languages', function (Builder $query) use ($value, $language_id) {
            $query->where('language_product.name', 'like', "%{$value}%")
                ->where('language_product.language_id', $language_id);
        });
    }
}
