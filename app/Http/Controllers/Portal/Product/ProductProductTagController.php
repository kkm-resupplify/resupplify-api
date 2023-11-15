<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductDto;
use App\Models\Product\Product;
use App\Models\Product\ProductTag;
use App\Models\Warehouse\Warehouse;
use App\Services\Product\ProductProductTagService;
use App\Services\Product\ProductService;
use App\Http\Dto\Product\ProductProductTagDto;
use Illuminate\Http\Request;

class ProductProductTagController extends Controller
{
    public function store(ProductProductTagService $productProductTagService, ProductProductTagDto $request)
    {
        return $this->ok($productProductTagService->addProductTagToProduct($request));
    }
    public function destroy(ProductProductTagService $productProductTagService, ProductProductTagDto $request)
    {
        return $this->ok($productProductTagService->deleteProductTagFromProduct($request));
    }
}
