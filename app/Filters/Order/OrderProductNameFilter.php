<?php

namespace App\Filters\Order;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\Filters\Filter;

class OrderProductNameFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $language_id = app('authUser')->language_id;

        return $query->whereHas('orderItems', function (Builder $query) use ($value, $language_id) {
            $query->whereHas('product', function (Builder $query) use ($language_id, $value) {
                $query->whereHas('languages', function (Builder $query) use ($value, $language_id) {
                    $query->where('language_product.name', 'like', "%{$value}%")
                        ->where('language_product.language_id', $language_id);
                });
            });
        });
    }
}
