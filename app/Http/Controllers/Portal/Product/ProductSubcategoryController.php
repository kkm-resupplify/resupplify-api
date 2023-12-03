<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductSubcategoryService;

class ProductSubcategoryController extends Controller
{
    public function index(ProductSubcategoryService $productSubcategoryService)
    {
        return $this->ok($productSubcategoryService->getProductSubcategories());
    }
}
