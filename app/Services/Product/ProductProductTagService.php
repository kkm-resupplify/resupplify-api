<?php

namespace App\Services\Product;
use App\Exceptions\Product\ProductNotFoundException;
use App\Http\Dto\Product\ProductProductTagDto;
use App\Models\Product\Product;
use App\Models\Product\ProductTag;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;

class ProductProductTagService extends BasicService
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
