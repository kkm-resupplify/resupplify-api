<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductDto;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use App\Services\Product\ProductCategoryService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(ProductCategoryService $productCategoryService)
    {
        return $this->ok($productCategoryService->getProductCategories());
    }
}
