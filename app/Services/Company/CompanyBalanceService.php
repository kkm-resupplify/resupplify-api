<?php

namespace App\Services\Company;


use App\Http\Dto\Company\CompanyTransactionDto;
use App\Http\Dto\Company\CompanyBalanceDto;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\Company;
use App\Models\Company\CompanyBalanceTransaction;
use App\Exceptions\Company\NegativeCompanyBalanceException;
use App\Exceptions\Company\WrongTransactionException;

class CompanyBalanceService extends BasicService
{
    public function createTransaction(CompanyTransactionDto $request)
    {
        $companySender = Company::findOrFail($request->senderId);
        $companyReceiver = Company::findOrFail($request->receiverId);
        if($companySender->id == $companyReceiver->id)
        {
            throw(new WrongTransactionException());
        }
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
        $balanceSender = $companySenderBalance->balance - $companyBalanceTransaction->amount;
        $balanceReceiver = $companyReceiverBalance->balance + $companyBalanceTransaction->amount;
        if($balanceSender < 0 || $balanceReceiver < 0)
        {
            throw(new NegativeCompanyBalanceException());
        }
        $transaction = $companyBalanceTransaction->save();
        $companyReceiverBalanceData = [
            'balance' => $balanceReceiver,
        ];
        $companySenderBalanceData = [
            'balance' => $balanceSender,
        ];
        $companyReceiverBalance->update($companyReceiverBalanceData);
        $companySenderBalance->update($companySenderBalanceData);
        return $companyReceiverBalance;
    }


    public function addBalance(CompanyBalanceDto $request)
    {
        $user = Auth::user();
        $company = $user->company;
        $companyBalance = $company->companyBalances;
        $companyBalanceTransactionData = [
            'company_id' => $companyBalance->company_id,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'type' => $request->type,
            'status' => $request->status,
            'sender_id' => null,
            'receiver_id' => $company->id,
            'payment_method_id' => $request->paymentMethodId
        ];
        if($request->amount < 0)
        {
            throw(new NegativeCompanyBalanceException());
        }
        $balance = $companyBalance->balance + $companyBalanceTransactionData['amount'];
        $companyBalance->balance = $balance;
        $companyBalance->save();
        return $companyBalance;
    }

}


