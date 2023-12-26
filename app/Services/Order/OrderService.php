<?php

namespace App\Services\Order;


use App\Models\Order\Order;
use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Order\OrderDto;
use App\Models\Product\ProductOffer;
use App\Http\Dto\Company\TransactionDto;
use App\Models\Order\Enums\OrderStatusEnum;
use App\Services\Company\CompanyBalanceService;
use App\Exceptions\Company\WrongTransactionException;
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
        $user = app('authUser');
        $company = $user->company;
        $orders = Order::with('orderProductOffer')->get();
        return $orders;
    }
}
