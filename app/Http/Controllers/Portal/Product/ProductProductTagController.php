<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductProductTagDto;
use App\Services\Product\ProductProductTagService;

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
