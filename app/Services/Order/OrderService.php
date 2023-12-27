<?php

namespace App\Services\Order;


use App\Models\Order\Order;
use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Order\OrderDto;
use App\Models\Product\ProductOffer;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Dto\Order\OrderStatusDto;
use App\Resources\Order\OrderResource;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Dto\Company\TransactionDto;
use App\Models\Order\Enums\OrderStatusEnum;
use App\Filters\Order\OrderProductNameFilter;
use App\Services\Company\CompanyBalanceService;
use App\Filters\Order\OrderProductCategoryFilter;
use App\Filters\Order\OrderProductSubcategoryFilter;
use App\Exceptions\Order\OrderCantBuyProductException;
use App\Exceptions\Order\OrderNotEnoughBalanceException;
use App\Exceptions\Order\OrderNotEnoughProductException;
use App\Exceptions\Product\ProductOfferNotFoundException;
use App\Models\Company\Enums\CompanyBalanceTransactionTypeEnum;

class OrderService extends BasicService
{
    use PaginationTrait;

    public function createOrder(OrderDto $request)
    {
        $user = app('authUser');
        $company = $user->company;
        $companyBalance = $company->companyBalances;
        $offer = ProductOffer::findOrFail($request->offerId);

        if($offer->status == 0)
        {
            throw new ProductOfferNotFoundException();
        }

        $offerCompany = $offer->product->company;
        $offerCompanyBalance = $offerCompany->companyBalances;

        if($offerCompany->id == $company->id)
        {
            throw new OrderCantBuyProductException();
        }

        $offerPrice = $offer->price*$request->orderQuantity;

        if ($offerPrice > $companyBalance->balance) {
            throw new OrderNotEnoughBalanceException();
        }
        if($offer->product_quantity < $request->orderQuantity)
        {
            throw new OrderNotEnoughProductException();
        }
        $transactionDto = new TransactionDto(
            $companyBalanceId = $offerCompanyBalance -> company_id,
            $currency = 'Euro',
            $amount = $offerPrice,
            $type = CompanyBalanceTransactionTypeEnum::SALE()->value,
            $status = 1,
            $senderId = $company->id,
            $receiverId = $offerCompany->id,
            $paymentMethodId = 1
        );

        $sellerTransaction = CompanyBalanceService::createTransaction($transactionDto);
        $sellerCompanyBalance = CompanyBalanceService::handleCompanyBalance($offerCompanyBalance, $sellerTransaction);

        $transactionDto = new TransactionDto(
            $companyBalanceId = $companyBalance->company_id,
            $currency = 'Euro',
            $amount = $offerPrice,
            $type = CompanyBalanceTransactionTypeEnum::PURCHASE()->value,
            $status = 1,
            $senderId = $company->id,
            $receiverId = $offerCompany->id,
            $paymentMethodId = 1
        );

        $buyerTransaction = CompanyBalanceService::createTransaction($transactionDto);
        $buyerCompanyBalance = CompanyBalanceService::handleCompanyBalance($companyBalance, $buyerTransaction);

        $offer->product_quantity = $offer->product_quantity - $request->orderQuantity;
        $productWarehouse = $offer->productWarehouse()->get();
        $productWarehouse->quantity = $offerCompany->quantity - $request->orderQuantity;

        if($offer->product_quantity == 0)
        {
            $offer->status = 0;
        }

        $offer->save();
        $order = new Order([
            'buyer_id' => $company->id,
            'seller_id' => $offerCompanyBalance -> company_id,
            'status' => OrderStatusEnum::COMPLETED(),
        ]);

        $order->save();
        $order->productOffers()->attach($offer->id, ['offer_quantity' => $request->orderQuantity]);
        $order->load('productOffers');

        return $order;
    }

    public function getListOfOrdersPlacedByAuthCompany()
    {
        $company = app('authUserCompany');
        $orders = Order::with('productOffers')->where(function($order) use ($company)
        {
            $order->where('seller_id', $company->id);
        });

        $orders = QueryBuilder::for($orders)->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::custom('name', new OrderProductNameFilter()),
            AllowedFilter::custom('categoryId', new OrderProductCategoryFilter()),
            AllowedFilter::custom('subcategoryId', new OrderProductCategoryFilter()),
        ])
        ->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));
        $pagination = $this->paginate($orders);

        return array_merge($pagination, OrderResource::collection($orders)->toArray(request()));
    }

    public function getListOfOrdersBoughtByAuthCompany()
    {
        $company = app('authUserCompany');
        $orders = Order::with('productOffers')->where(function($order) use ($company)
        {
            $order->where('buyer_id', $company->id);
        });

        $orders = QueryBuilder::for($orders)->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::custom('name', new OrderProductNameFilter()),
            AllowedFilter::custom('categoryId', new OrderProductCategoryFilter()),
            AllowedFilter::custom('subcategoryId', new OrderProductCategoryFilter()),
        ])
        ->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));
        $pagination = $this->paginate($orders);

        return array_merge($pagination, OrderResource::collection($orders)->toArray(request()));
    }

    public function changeOrderStatus(OrderStatusDto $request)
    {
        $company = app('authUserCompany');
        $order = Order::findOrFail($request->orderId)->where('seller_id', $company->id)->first();
        $order->status = match ($request->status) {
            0 => OrderStatusEnum::PLACED(),
            1 => OrderStatusEnum::PROCESSING(),
            2 => OrderStatusEnum::SHIPPED(),
            3 => OrderStatusEnum::INTRANSIT(),
            4 => OrderStatusEnum::COMPLETED(),
            5 => OrderStatusEnum::CANCELLED(),
            6 => OrderStatusEnum::REFUNDED(),
            7 => OrderStatusEnum::REJECTED(),
            8 => OrderStatusEnum::SUSPENDED(),
            9 => OrderStatusEnum::INACTIVE(),
            default => OrderStatusEnum::COMPLETED(),
        };
        $order->save();

        return new OrderResource($order);
    }
}
