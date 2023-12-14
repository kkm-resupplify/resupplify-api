<?php

namespace App\Services\Company;


use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Dto\Company\CompanyBalanceDto;
use App\Models\Company\CompanyBalanceTransaction;
use App\Resources\Company\CompanyBalanceResource;
use App\Exceptions\Company\WrongTransactionException;
use App\Resources\Company\CompanyTransactionResource;
use App\Exceptions\Company\NegativeCompanyBalanceException;
use App\Models\Company\Enums\CompanyBalanceTransactionTypeEnum;
use App\Helpers\PaginationTrait;

class CompanyBalanceService extends BasicService
{
    use PaginationTrait;
    public function balanceOperation(CompanyBalanceDto $request)
    {
        $user = Auth::user();
        $company = $user->company;
        $companyBalance = $company->companyBalances;
        $companyBalanceTransactionData = [
            'company_balance_id' => $companyBalance->company_id,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'type' => $request->type,
            'status' => $request->status,
            'sender_id' => null,
            'receiver_id' => $company->id,
            'payment_method_id' => $request->paymentMethodId
        ];
        $transaction = new CompanyBalanceTransaction($companyBalanceTransactionData);

        if($companyBalanceTransactionData['type'] == CompanyBalanceTransactionTypeEnum::WITHDRAWAL()->value)
        {
            $balance = $companyBalance->balance - $companyBalanceTransactionData['amount'];
        }
        else
        {
            $balance = $companyBalance->balance + $companyBalanceTransactionData['amount'];
        }
        if($balance < 0)
        {
            throw(new NegativeCompanyBalanceException());
        }
        $companyBalance->balance = $balance;
        $companyBalance->save();
        $transaction->save();
        return $companyBalance;
    }

    public function showBalance()
    {
        $user = Auth::user();
        $company = $user->company;
        $companyBalance = $company->companyBalances;
        return new CompanyBalanceResource($companyBalance);
    }

    public function showBalanceOperations()
    {
        $user = Auth::user();
        $company = $user->company;
        $companyBalance = QueryBuilder::for($company->companyBalances->companyBalanceTransactions())->allowedFilters([
            AllowedFilter::exact('type'),
        ])->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));
        $pagination = $this->paginate($companyBalance);
        return array_merge($pagination, CompanyTransactionResource::collection($companyBalance)->toArray(request()));
    }
}


