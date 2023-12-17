<?php

namespace App\Services\Product;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\ProductOffers;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Dto\Product\ProductOfferDto;
use App\Exceptions\Product\ProductOfferExists;
use App\Filters\Product\ProductOfferNameFilter;
use App\Resources\Product\ProductOfferResource;
use App\Models\Product\Enums\ProductOfferStatusEnum;
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
        if($company->productOffers()->where('company_product_id', $request->productId)->where('product_offers.status',ProductOfferStatusEnum::ACTIVE())->first())
        {
           throw new ProductOfferExists();
        }
        $offer = new ProductOffers([
            'price' => $request->price,
            'product_quantity' => $request->productQuantity,
            'status' => $request->status,
            'company_product_id' => $request->productId,
            'started_at' => $request->startDate,
            'ended_at' => $request->endDate,
        ]);
        // $companyWarehouses->products()->updateExistingPivot($request->productId,
        // ['quantity' => $productInCompanyWarehouses->pivot->quantity - $request->productQuantity]);
        $offer->save();
        $offer->load('product');
        return new ProductOfferResource($offer);
    }

    public function getOffers()
    {
        $offers = QueryBuilder::for(ProductOffers::with('product'))->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::custom('name', new ProductOfferNameFilter()),
        ])->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));
        $pagination = $this->paginate($offers);
        return array_merge($pagination,ProductOfferResource::collection($offers)->toArray(request()));;
    }

    public function getOffer(ProductOffers $offer)
    {
        return $offer;
        return new ProductOfferResource($offer);
    }

    public function changeStatus()
    {
        $currentDate = now();
        $activeOffers = ProductOffers::where('started_at', '<=', $currentDate)
            ->where('ended_at', '>=', $currentDate)
            ->update(['status' => ProductOfferStatusEnum::ACTIVE()]);

        $inactiveOffers = ProductOffers::where('ended_at', '<', $currentDate)
            ->update(['status' => ProductOfferStatusEnum::INACTIVE()]);
        return [$activeOffers,$inactiveOffers];
    }
}
