<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductDto;
use App\Models\Product\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(ProductService $productService, ProductDto $request)
    {
        return $this->ok($productService->createWarehouse($request));
    }

    public function show(ProductService $productService, Product $product)
    {
        return $this->ok($productService->getWarehouse($product));
    }
    public function index(ProductService $productService)
    {
        return $this->ok($productService->getWarehouses());
    }

    public function update(ProductService $productService, ProductDto $request, Product $product)
    {
        return $this->ok($productService->editWarehouse($request, $product));
    }

    public function destroy(ProductService $productService, Product $product)
    {
        return $this->ok($productService->deleteWarehouse($product));
    }
}
