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
    return $this->ok($productService->getCompanies());
  }

  public function unverifiedCompanies(ProductService $productService)
  {
    return $this->ok($productService->getUnverifiedCompanies());
  }

  public function verifiedCompanies(ProductService $productService)
  {
    return $this->ok($productService->getVerifiedCompanies());
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
