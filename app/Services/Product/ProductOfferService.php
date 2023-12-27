<?php

namespace App\Services\Product;

use App\Models\Product\Enums\ProductStatusEnum;
use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Product\ProductOffer;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Dto\Product\ProductOfferDto;
use App\Resources\Product\ProductResource;
use App\Exceptions\Product\ProductOfferExists;
use App\Filters\Product\ProductOfferNameFilter;
use App\Resources\Product\ProductOfferResource;
use App\Filters\Product\ProductOfferCategoryFilter;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Product\Enums\ProductOfferStatusEnum;
use App\Resources\Product\ProductPositionInWarehouse;
use App\Exceptions\Product\ProductOfferNotFoundException;
use App\Exceptions\Product\ProductOfferQuantityException;


class ProductOfferService extends BasicService
{
    use PaginationTrait;
    public function createOffer(ProductOfferDto $request)
    {
        $company = app('authUserCompany');
        $warehouseProduct = DB::table('product_warehouse')->where('id', $request->stockItemId)->get();

        if ($warehouseProduct->isEmpty()) {
            throw new ProductNotFoundException();
        }

        $companyWarehouses = $company->warehouses()->findOrFail($warehouseProduct[0]->warehouse_id);
        $productInCompanyWarehouses = $companyWarehouses->products()->findOrFail($warehouseProduct[0]->product_id);

        $request->startDate = date('Y-m-d H:i:s', strtotime($request->startDate));
        $request->endDate = date('Y-m-d H:i:s', strtotime($request->endDate));

        $companyProductOffersOverlap = $company->productOffers()
            ->where('product_offers.company_product_id', $request->stockItemId)
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('product_offers.started_at', '>=', $request->startDate)
                        ->where('product_offers.started_at', '<', $request->endDate);
                })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('product_offers.ended_at', '>', $request->startDate)
                            ->where('product_offers.ended_at', '<=', $request->endDate);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('product_offers.started_at', '<=', $request->startDate)
                            ->where('product_offers.ended_at', '>=', $request->endDate);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('product_offers.started_at', '>=', $request->startDate)
                            ->where('product_offers.ended_at', '<=', $request->endDate);
                    });
            })
            ->get();

        if ($request->productQuantity > $productInCompanyWarehouses->pivot->quantity) {
            throw new ProductOfferQuantityException();
        }

        if ($companyProductOffersOverlap->count() > 0) {
            throw new ProductOfferExists();
        }

        $offer = new ProductOffer([
            'price' => $request->price,
            'product_quantity' => $request->productQuantity,
            'status' => $request->status,
            'company_product_id' => $warehouseProduct[0]->id,
            'started_at' => $request->startDate,
            'company_id' => $company->id,
            'ended_at' => $request->endDate,
        ]);

        $offer->save();
        $offer->load('product');

        return new ProductOfferResource($offer);
    }

    public function getOffers()
    {
        // We prolly should fetch all products regardless -> in case one wants to see their own offers
        // on the page with all offers

        // $company = app('authUserCompany');
        $productOffers = ProductOffer::with('product', 'productWarehouse', 'company')->where(function ($query) {
            $query->whereHas('productWarehouse', function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('status','!=', ProductStatusEnum::INACTIVE());
                });
            });
        });

        // ->whereDoesntHave('product', function ($query) use ($company) {
        //     $query->where('company_id', $company->id);
        // });

        $offers = QueryBuilder::for($productOffers)->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::custom('name', new ProductOfferNameFilter()),
            AllowedFilter::exact('subcategoryId', 'product.product_subcategory_id'),
            AllowedFilter::custom('categoryId', new ProductOfferCategoryFilter()),
        ])
        ->allowedSorts(['price','ended_at'])
        ->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));
        $pagination = $this->paginate($offers);

        return array_merge($pagination, ProductOfferResource::collection($offers)->toArray(request()));
    }

    public function getOffer(ProductOffer $offer)
    {
        return new ProductOfferResource($offer->load('product'));
    }

    public function getUserCompanyOffers()
    {
        $company = app('authUserCompany');
        $offers = QueryBuilder::for($company->productOffers()->with('product', 'productWarehouse'))->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::custom('name', new ProductOfferNameFilter()),
            AllowedFilter::exact('subcategoryId', 'product.product_subcategory_id'),
            AllowedFilter::custom('categoryId', new ProductOfferCategoryFilter()),
        ])
        ->allowedSorts(['price','ended_at'])
        ->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));

        $pagination = $this->paginate($offers);

        return array_merge($pagination, ProductOfferResource::collection($offers)->toArray(request()));
    }

    public function changeStatus()
    {
        $currentDate = now();

        $activeOffers = ProductOffer::where('started_at', '<=', $currentDate)
            ->where('ended_at', '>=', $currentDate)
            ->update(['status' => ProductOfferStatusEnum::ACTIVE()]);
        $inactiveOffers = ProductOffer::where('ended_at', '<', $currentDate)
            ->update(['status' => ProductOfferStatusEnum::INACTIVE()]);

        return [$activeOffers, $inactiveOffers];
    }

    public function deactivateOffer(ProductOffer $offer)
    {
        if (!self::checkIfOfferIsCreatedByCompany($offer->id, app('authUserCompany')->id)) {
            throw new ProductOfferNotFoundException();
        }

        $offer->update(['status' => ProductOfferStatusEnum::INACTIVE()]);
        $offer->delete();

        return new ProductOfferResource($offer);
    }

    public function possitions()
    {
        $company = app('authUserCompany');
        $companyWarehouses = $company->warehouses;
        $warehouseProduct = DB::table('product_warehouse')
            ->whereIn('warehouse_id', $companyWarehouses->pluck('id'))
            ->get();

        return ProductPositionInWarehouse::collection($warehouseProduct);
    }

    public function checkIfOfferIsCreatedByCompany($offerId, $companyId)
    {
        $offer = ProductOffer::where('id', $offerId)->first();
        $offerCompany = $offer->product->company;

        return $offerCompany->id == $companyId;
    }

    public function getCompanyOffers($company)
    {
        $offers = QueryBuilder::for($company->productOffers()->with('product', 'productWarehouse'))->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::custom('name', new ProductOfferNameFilter()),
            AllowedFilter::exact('subcategoryId', 'product.product_subcategory_id'),
            AllowedFilter::custom('categoryId', new ProductOfferCategoryFilter()),
        ])
        ->allowedSorts(['price','ended_at'])
        ->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));

        $pagination = $this->paginate($offers);

        return array_merge($pagination, ProductOfferResource::collection($offers)->toArray(request()));
    }
}
