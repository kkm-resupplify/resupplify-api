<?php

namespace App\Services\Order;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Order\OrderDto;
use App\Models\Product\ProductOffer;
use App\Exceptions\Company\WrongTransactionException;
use App\Exceptions\Product\ProductOfferNotFoundException;

class OrderService extends BasicService
{
    use PaginationTrait;

    public function createOrder(OrderDto $request)
    {
        $user = app('authUser');
        $company = $user->company;
        $companyBalance = $company->companyBalances;
        $offer = ProductOffer::findOrFail($request->offerId);
        if ($offer->company_id == $company->id) {
            throw new ProductOfferNotFoundException();
        }
        $offerPrice = $offer->price*$request->orderQuantity;
        if ($offerPrice > $companyBalance->balance) {
            //todo: dodać tłumaczenie
            throw new WrongTransactionException("You don't have enough money to make this offer");
        }
        if($offer->product_quantity < $request->orderQuantity)
        {
            //todo: dodać exception
            throw new WrongTransactionException("You can't make this order: not enough products in offer");
        }
        $companyBalanceTransactionData = [
            'company_balance_id' => $companyBalance->company_id,
            'currency' => 'Euro',
            'amount' => $offerPrice,
            'type' => $request->type,
            'status' => $request->status,
            'sender_id' => null,
            'receiver_id' => $company->id,
            'payment_method_id' => $request->paymentMethodId
        ];
        $offer->product_quantity = $offer->product_quantity - $request->orderQuantity;
        $offer->save();
        $companyBalance->balance = $companyBalance->balance - $offerPrice;
        //todo: tworzenie transakcji
        //todo: zmiana statusu
        //todo: tworzenie zamówienia
        $companyBalance->save();
        return $offer;
    }
}
