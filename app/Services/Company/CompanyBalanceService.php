<?php

namespace App\Services\Company;


use App\Http\Dto\Company\CompanyBalanceDto;
use App\Models\Company\CompanyCategory;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\Company;
use App\Models\Company\CompanyBalanceTransaction;
use App\Exceptions\Company\NegativeCompanyBalanceException;

class CompanyBalanceService extends BasicService
{
    public function createTransaction(CompanyBalanceDto $request)
    {
        $user = Auth::user();
        $company = $user->company;
    //    if($company->id != $request->receiverId)
        $companySender = Company::findOrFail($request->senderId);
        $companyReceiver = Company::findOrFail($request->receiverId);
        $companySenderBalance = $companySender->companyBalances;
        $companyReceiverBalance = $companyReceiver->companyBalances;
        $companyBalanceTransactionData = [
            'company_id' => $companyReceiverBalance->company_id,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'type' => $request->type,
            'status' => $request->status,
            'sender_id' => $request->senderId ?? null,
            'receiver_id' => $request->receiverId,
            'payment_method_id' => $request->paymentMethodId
        ];
        $companyBalanceTransaction = new CompanyBalanceTransaction($companyBalanceTransactionData);
        $balance = $companyReceiverBalance->balance + $companyBalanceTransaction->amount;
        if($balance < 0)
        {
            throw(new NegativeCompanyBalanceException());
        }
        $transaction = $companyBalanceTransaction->save();
        $companyBalanceData = [
            'balance' => $balance,
        ];
        $companyReceiverBalance->update($companyBalanceData);
        return $companyReceiverBalance;
    }
}


