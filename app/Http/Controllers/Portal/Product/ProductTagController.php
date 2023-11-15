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
