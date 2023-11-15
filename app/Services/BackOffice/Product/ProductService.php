<?php

namespace App\Services\BackOffice\Product;

use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductAlreadyVerifiedException;

use App\Http\Controllers\Controller;

use App\Models\Product\Enums\ProductStatusEnum;

use App\Resources\Product\ProductCollection;
use App\Resources\Product\ProductResource;

use App\Http\Dto\Product\ProductMassVerifyDto;

use App\Models\Product\Product;

class ProductService extends Controller
{
  public function getCompanies()
  {
    return new ProductCollection(Product::all());
  }

  public function getUnverifiedCompanies()
  {
    return new ProductCollection(Product::where('status', ProductStatusEnum::UNVERIFIED())->get());
  }

  public function getVerifiedCompanies()
  {
    return new ProductCollection(Product::where('status', ProductStatusEnum::VERIFIED())->get());
  }

  public function verifyProduct($productId)
  {
    $product = Product::find($productId);

    if (!isset($product)) {
      throw new ProductNotFoundException();
    }

    if ($product->status == ProductStatusEnum::VERIFIED()) {
      throw new ProductAlreadyVerifiedException();
    }

    $product->status = ProductStatusEnum::VERIFIED();
    $product->save();

    return $product;
  }

  public function rejectProduct($productId)
  {
    $product = Product::find($productId);

    if (!isset($product)) {
      throw new ProductNotFoundException();
    }

    $product->status = ProductStatusEnum::REJECTED();
    $product->save();

    return $product;
  }

  public function massStatusUpdate(ProductMassVerifyDto $statusUpdateDTO)
  {
    Product::whereIn('id', $statusUpdateDTO->productIds)->update(['status' => $statusUpdateDTO->newStatus]);

    return ['status' => $statusUpdateDTO->newStatus];
  }
}
