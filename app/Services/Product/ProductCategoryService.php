<?php

namespace App\Services\Product;
use App\Models\Product\ProductCategory;
use App\Resources\Product\ProductCategoryAndSubcategoryResource;
use App\Resources\Product\ProductCategoryResource;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;

class ProductCategoryService extends BasicService
{
    public function getProductCategories()
    {
        $user = app('authUser');
        return ProductCategoryResource::collection(ProductCategory::whereHas('languages', function ($query) use (
            $user
        ) {
            $query->where('languages.id', $user->language->id);
        })
            ->with([
                'languages' => function ($query) use ($user) {
                    $query->where('languages.id', $user->language->id);
                },
            ])
            ->get());
    }

    public function getProductCategory(ProductCategory $productCategory)
    {
        return new ProductCategoryAndSubcategoryResource($productCategory);
    }
}
