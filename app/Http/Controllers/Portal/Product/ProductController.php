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
        return $this->ok($productService->createProduct($request));
    }

    public function show(ProductService $productService, Product $product)
    {
        return $this->ok($productService->getProduct($product));
    }
    public function index(ProductService $productService)
    {
        return $this->ok($productService->getProducts());
    }

    public function update(ProductService $productService, ProductDto $request, Product $product)
    {
        return $this->ok($productService->editProduct($request, $product));
    }

    public function destroy(ProductService $productService, Product $product)
    {
        return $this->ok($productService->deleteProduct($product));
    }

    public function massAssignProductsStatus(ProductService $productService, Request $product)
    {
        return $this->ok($productService->massAssignProductStatus($product));
    }

    public function productStats(ProductService $productService)
    {
        return $this->ok($productService->getProductStats());
    }
}
