<?php

namespace App\Filters\Product;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ProductNameFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $language_id = Auth::user()->language_id;

        return $query->whereHas('languages', function (Builder $query) use ($value, $language_id) {
            $query->where('language_product.name', 'like', "%{$value}%")
                ->where('language_product.language_id', $language_id);
        });
    }
}
