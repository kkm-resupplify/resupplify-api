<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductUnitService;

class ProductUnitController extends Controller
{
    public function index(ProductUnitService $productUnitService)
    {
        return $this->ok($productUnitService->getProductUnits());
    }
}
