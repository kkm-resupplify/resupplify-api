<?php

namespace App\Services\BackOffice\Product;

use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductAlreadyVerifiedException;

use App\Services\BasicService;

use App\Models\Product\Enums\ProductVerificationStatusEnum;

use App\Resources\BackOffice\Product\ProductResource;

use App\Http\Dto\Product\ProductMassVerifyDto;

use App\Models\Product\Product;

class ProductService extends BasicService
{
  public function getProducts()
  {
    return ProductResource::collection(Product::all());
  }

  public function getUnverifiedProducts()
  {
    return ProductResource::collection(
      Product::whereIn('verification_status', [
        ProductVerificationStatusEnum::UNVERIFIED(),
        ProductVerificationStatusEnum::REJECTED()
      ])->get()
    );
  }

  public function getVerifiedProducts()
  {
    return ProductResource::collection(
      Product::where('verification_status', ProductVerificationStatusEnum::VERIFIED())->get()
    );
  }

  public function verifyProduct($productId)
  {
    $product = Product::find($productId);

    if (!isset($product)) {
      throw new ProductNotFoundException();
    }

    if ($product->verification_status == ProductVerificationStatusEnum::VERIFIED()) {
      throw new ProductAlreadyVerifiedException();
    }

    $product->verification_status = ProductVerificationStatusEnum::VERIFIED();
    $product->save();

    return $product;
  }

  public function rejectProduct($productId)
  {
    $product = Product::find($productId);

    if (!isset($product)) {
      throw new ProductNotFoundException();
    }

    $product->verification_status = ProductVerificationStatusEnum::REJECTED();
    $product->save();

    return $product;
  }

  public function massStatusUpdate(ProductMassVerifyDto $statusUpdateDTO)
  {
    Product::whereIn('id', $statusUpdateDTO->productIds)
      ->update(['verification_status' => $statusUpdateDTO->newStatus]);

    return ['verification_status' => $statusUpdateDTO->newStatus];
  }
}
