<?php

namespace App\Services\Product;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\ProductOffers;
use App\Http\Dto\Product\ProductOfferDto;
use App\Exceptions\Product\ProductOfferQuantityException;


class ProductOfferService extends BasicService
{
    use PaginationTrait;
    public function createOffer(ProductOfferDto $request)
    {
        $company = app('authUserCompany');
        $companyWarehouses = $company->warehouses()->findOrFail($request->warehouseId);
        $productInCompanyWarehouses = $companyWarehouses->products()->findOrFail($request->productId);
        if($request->productQuantity > $productInCompanyWarehouses->pivot->quantity)
        {
            throw new ProductOfferQuantityException();
        }
        $offer = new ProductOffers([
            'price' => $request->price,
            'product_quantity' => $request->productQuantity,
            'status' => $request->status,
            'company_product_id' => $request->productId,
        ]);
        $companyWarehouses->products()->updateExistingPivot($request->productId,
        ['quantity' => $productInCompanyWarehouses->pivot->quantity - $request->productQuantity]);
        $offer->save();
        return $offer;
    }
}
