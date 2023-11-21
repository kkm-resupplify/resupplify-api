<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductTag;
use App\Services\Product\ProductTagService;
use App\Http\Dto\Product\ProductTagDto;

class ProductTagController extends Controller
{
    public function index(ProductTagService $productTagService)
    {
        return $this->ok($productTagService->getProductTags());
    }
    public function store(ProductTagService $productTagService, ProductTagDto $request)
    {
        return $this->ok($productTagService->createProductTag($request));
    }
    public function update(ProductTagService $productTagService, ProductTagDto $request, ProductTag $productTag)
    {
        return $this->ok($productTagService->updateProductTag($request,$productTag));
    }
    public function destroy(ProductTagService $productTagService, ProductTag $productTag)
    {
        return $this->ok($productTagService->deleteProductTag($productTag));
    }
    public function show(ProductTagService $productTagService, ProductTag $productTag)
    {
        return $this->ok($productTagService->getProductTag($productTag));
    }


}
