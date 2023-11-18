<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductDto;
use App\Models\Product\Product;
use App\Models\Product\ProductTag;
use App\Models\Warehouse\Warehouse;
use App\Services\Product\ProductTagService;
use App\Services\Product\ProductService;
use App\Http\Dto\Product\ProductTagDto;
use Illuminate\Http\Request;
use App\Services\Product\ProductUnitService;

class ProductUnitController extends Controller
{
    public function index(ProductUnitService $productUnitService)
    {
        return $this->ok($productUnitService->getProductUnits());
    }
}
