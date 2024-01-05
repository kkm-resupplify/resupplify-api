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
use App\Exceptions\Order\OrderCantButProductQuantityException;
use App\Models\Company\Enums\CompanyBalanceTransactionTypeEnum;

class OrderService extends BasicService
{
    use PaginationTrait;

    public function createOrder(OrderDto $request)
    {
        $user = app('authUser');
        $buyerCompany = $user->company;
        $buyerCompanyBalance = $buyerCompany->companyBalances;
        $orderOffers = [];

        $orderCost = 0;

        foreach ($request->order as $orderItem) {
            $offer = ProductOffer::findOrFail($orderItem['offerId']);
            $offerWarehouse = $offer->productWarehouse()->first();

            if ($offer->status == 0) {
                throw new ProductOfferNotFoundException();
            }

            $offerCompany = $offer->product->company;

            if ($offerCompany->id == $buyerCompany->id) {
                throw new OrderCantBuyProductException();
            }

            if (
                $offer->product_quantity < $orderItem['orderQuantity']
                || $offerWarehouse['quantity'] < $orderItem['orderQuantity']
            ) {
                throw new OrderCantButProductQuantityException();
            }



            $offerPrice = $offer->price * $orderItem['orderQuantity'];
            if($offerPrice <= 0)
            {
                throw new OrderCantBuyProductException();
            }
            $orderCost += $offerPrice;
            $orderOffers[] = $offer;
        }

        if ($orderCost > $buyerCompanyBalance->balance) {
            throw new OrderNotEnoughBalanceException();
        }


        $sellerCompany = $offer->product->company;
        $sellerCompanyBalance = $sellerCompany->companyBalances;

        $order = new Order([
            'buyer_id' => $buyerCompany->id,
            'seller_id' => $sellerCompany->id,
            'status' => OrderStatusEnum::PLACED(),
        ]);

        $order->save();

        foreach ($request->order as $idx => $orderItem) {
            $orderQuantity = $orderItem['orderQuantity'];
            $order->orderItems()->attach($orderItem['offerId'], ['offer_quantity' => $orderQuantity]);

            $offer = $orderOffers[$idx];
            $offer->product_quantity -= $orderQuantity;

            $productWarehouse = $offer->productWarehouse()->first();
            $productWarehouse->quantity -= $orderQuantity;

            if ($offer->product_quantity == 0) {
                $offer->status = 0;
            }

            if ($productWarehouse->quantity == 0) {
                $productWarehouse->status = 0;
            }

            $offer->save();
            $productWarehouse->save();
        }

        $sellerTransactionDto = new TransactionDto(
            $sellerCompanyBalance->id,
            'Euro',
            $orderCost,
            CompanyBalanceTransactionTypeEnum::SALE()->value,
            1,
            $buyerCompany->id,
            $sellerCompany->id,
            1
        );

        $sellerTransaction = CompanyBalanceService::createTransaction($sellerTransactionDto);
        CompanyBalanceService::handleCompanyBalance($sellerCompanyBalance, $sellerTransaction);

        $buyerTransactionDto = new TransactionDto(
            $buyerCompanyBalance->id,
            'Euro',
            $orderCost,
            CompanyBalanceTransactionTypeEnum::PURCHASE()->value,
            1,
            $buyerCompany->id,
            $sellerCompany->id,
            1
        );

        $buyerTransaction = CompanyBalanceService::createTransaction($buyerTransactionDto);
        CompanyBalanceService::handleCompanyBalance($buyerCompanyBalance, $buyerTransaction);

        return new OrderResource($order);
    }

    public function getListOfOrdersPlacedByAuthCompany()
    {
        $company = app('authUserCompany');
        $orders = Order::with('orderItems', 'buyer')->where(function ($order) use ($company) {
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
        $orders = Order::with('orderItems', 'seller')->where(function ($order) use ($company) {
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
