<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductCategory;
use App\Services\Product\ProductCategoryService;

class ProductCategoryController extends Controller
{
    public function index(ProductCategoryService $productCategoryService)
    {
        return $this->ok($productCategoryService->getProductCategories());
    }

    public function show(ProductCategoryService $productCategoryService, ProductCategory $productCategory)
    {
        return $this->ok($productCategoryService->getProductCategory($productCategory));
    }
}
