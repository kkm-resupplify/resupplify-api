<?php

namespace App\Services\Product;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\ProductOffer;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Dto\Product\ProductOfferDto;
use App\Exceptions\Product\ProductOfferExists;
use App\Filters\Product\ProductOfferNameFilter;
use App\Resources\Product\ProductOfferResource;
use App\Filters\Product\ProductOfferCategoryFilter;
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
        $offer = new ProductOffer([
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
        $offers = QueryBuilder::for(ProductOffer::with('product'))->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::custom('name', new ProductOfferNameFilter()),
            AllowedFilter::exact('subcategoryId', 'product.product_subcategory_id'),
            AllowedFilter::custom('categoryId', new ProductOfferCategoryFilter()),
        ])->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));
        $pagination = $this->paginate($offers);
        return array_merge($pagination,ProductOfferResource::collection($offers)->toArray(request()));;
    }

    public function getOffer(ProductOffer $offer)
    {
        return $offer;
        return new ProductOfferResource($offer);
    }

    public function changeStatus()
    {
        $currentDate = now();
        $activeOffers = ProductOffer::where('started_at', '<=', $currentDate)
            ->where('ended_at', '>=', $currentDate)
            ->update(['status' => ProductOfferStatusEnum::ACTIVE()]);

        $inactiveOffers = ProductOffer::where('ended_at', '<', $currentDate)
            ->update(['status' => ProductOfferStatusEnum::INACTIVE()]);
        return [$activeOffers,$inactiveOffers];
    }
}
