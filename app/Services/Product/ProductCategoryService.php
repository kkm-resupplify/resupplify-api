<?php

namespace App\Services\Product;

use App\Exceptions\Company\WrongPermissions;
use App\Exceptions\Product\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductDto;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Models\Product\Enums\ProductVerificationStatusEnum;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Models\Warehouse\Warehouse;
use App\Resources\Product\ProductResource;
use Illuminate\Support\Facades\Auth;

class ProductCategoryService extends Controller
{
    // public function getProduct(Product $product)
    // {
    //     return new ProductResource($product);
    // }
    public function getProductCategories()
    {
        $user = Auth::user();
        return ProductCategory::find(1)->language;
        return ProductResource::collection($user->company->products()->get());
    }
}
