<?php

namespace App\Services\Product;

use App\Models\Product\ProductSubcategory;
use App\Resources\Product\ProductSubcategoryResource;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;

class ProductSubcategoryService extends BasicService
{
    public function getProductSubcategories()
    {
        $user = app('authUser');

        return ProductSubcategoryResource::collection(ProductSubcategory::whereHas('languages', function ($query) use (
            $user
        ) {
            $query->where('languages.id', $user->language->id ?? 1);
        })
            ->with([
                'languages' => function ($query) use ($user) {
                    $query->where('languages.id', $user->language->id ?? 1);
                },
            ])
            ->get());
    }
}
