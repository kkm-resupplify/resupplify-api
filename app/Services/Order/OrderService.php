<?php

namespace App\Services\Order;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Order\OrderDto;
use App\Models\Product\ProductOffer;
use App\Http\Dto\Company\TransactionDto;
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
        $offerCompany = $offer->product->company;

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
            $companyBalanceId = $companyBalance->company_id,
            $currency = 'Euro',
            $amount = $offerPrice,
            $type = CompanyBalanceTransactionTypeEnum::SALE()->value,
            $status = 1,
            $senderId = $company->id,
            $receiverId = $offerCompany->id,
            $paymentMethodId = 1
        );
        $sellerTransaction = CompanyBalanceService::createTransaction($transactionDto);
        $sellerCompanyBalance = CompanyBalanceService::handleCompanyBalance($companyBalance, $sellerTransaction);
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
        $productWarehouse = $offerCompany = $offer->product->warehouse;
        if($offer->product_quantity == 0)
        {
            $offer->status = 0;
        }
        $offer->save();
        return $offer;
    }
}
