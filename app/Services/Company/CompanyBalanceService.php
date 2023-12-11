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
       $companyBalance = $company->companyBalances;
       $companyBalanceTransactionData = [
       'company_id' => $companyBalance->company_id,
       'amount' => $request->amount,
       'type' => $request->type
       ];
       $companyBalanceTransaction = new CompanyBalanceTransaction($companyBalanceTransactionData);
       $balance = $companyBalance->balance + $companyBalanceTransaction->amount;
       if($balance < 0)
       {
        throw(new NegativeCompanyBalanceException());
       }
       $transaction = $companyBalanceTransaction->save();
       $companyBalanceData = [
        'balance' => $balance,
       ];
       $companyBalance->update($companyBalanceData);
       return $companyBalance;
    }
}


