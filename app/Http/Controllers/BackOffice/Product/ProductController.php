<?php

namespace App\Http\Controllers\BackOffice\Product;

use Illuminate\Http\JsonResponse;

use App\Services\BackOffice\Product\ProductService;

use App\Http\Controllers\Controller;

use App\Http\Dto\Product\ProductMassVerifyDto;

class ProductController extends Controller
{
  public function index(ProductService $productService): JsonResponse
  {
    return $this->ok($productService->getProducts());
  }

  public function unverifiedProducts(ProductService $productService)
  {
    return $this->ok($productService->getUnverifiedProducts());
  }

  public function verifiedProducts(ProductService $productService)
  {
    return $this->ok($productService->getVerifiedProducts());
  }

  public function verifyProduct(ProductService $productService, $productId)
  {

    return $this->ok($productService->verifyProduct($productId));
  }

  public function rejectProduct(ProductService $productService, $productId)
  {

    return $this->ok($productService->rejectProduct($productId));
  }

  public function massStatusUpdate(ProductService $productService, ProductMassVerifyDto $statusUpdateDTO)
  {

    return $this->ok($productService->massStatusUpdate($statusUpdateDTO));
  }
}
