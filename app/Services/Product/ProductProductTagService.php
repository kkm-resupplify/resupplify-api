<?php

namespace App\Services\Product;
use App\Resources\Product\ProductCategoryAndSubcategoryResource;
use App\Resources\Product\ProductCategoryResource;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Company\WrongPermissions;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductTag;
use App\Models\Product\Product;
use App\Http\Dto\Product\ProductProductTagDto;
use Illuminate\Support\Str;
use App\Exceptions\Product\ProductNotFoundException;
class ProductProductTagService extends Controller
{
    public function addProductTagToProduct(ProductProductTagDto $request)
    {
        $user = Auth::user();
        $product = Product::findOrFail($request->productId);
        $productTag = ProductTag::findOrFail($request->productTagId);
        $company = $user->company->products;
        if (!$company->contains($product))
        {
            throw(new ProductNotFoundException());
        }
        if (!$product->productTags->contains($productTag))
        {
            $product->productTags()->attach($productTag);
            return 1;
        }
        return 0;

    }

    public function deleteProductTagFromProduct(ProductProductTagDto $request)
    {
        $user = Auth::user();
        $product = Product::findOrFail($request->productId);
        $productTag = ProductTag::findOrFail($request->productTagId);
        $company = $user->company->products;
        if (!$company->contains($product))
        {
            throw(new ProductNotFoundException());
        }
        if ($product->productTags->contains($productTag))
        {
            $product->productTags()->detach($productTag);
            return 1;
        }
        return 0;
    }
}
