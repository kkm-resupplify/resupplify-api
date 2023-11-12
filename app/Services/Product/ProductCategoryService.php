<?php

namespace App\Services\Product;
use App\Resources\Product\ProductCategoryResource;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductCategory;

class ProductCategoryService extends Controller
{
    public function getProductCategories()
    {
        $user = Auth::user();
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
}
