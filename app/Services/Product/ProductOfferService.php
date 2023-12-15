<?php

namespace App\Services\Product;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Product\ProductOfferDto;
use Illuminate\Support\Facades\Auth;


class ProductOfferService extends BasicService
{
    use PaginationTrait;
    public function createOffer(ProductOfferDto $request)
    {
        $user = app('authUser');
        $company = app('authUserCompany');
        $product = $company->products()->findOrFail($request->productId);
        return $productInCompanyWarehouses = $product->warehouses;
        //TODO: Implement createOffer method logic
        $offer = $company->offers()->create([
            'price' => $request->price,
            'productQuantity' => $request->price,
            'status' => $request->status,
            'product_id' => $request->productId,
        ]);
        return $offer;
    }
}
