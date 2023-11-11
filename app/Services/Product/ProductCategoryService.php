<?php

namespace App\Services\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductCategory;

class ProductCategoryService extends Controller
{
    public function getProductCategories()
    {
        return ProductCategory::with('languages')->get();
    }
}
