<?php

namespace App\Services\Company;


use App\Services\BasicService;
use App\Models\Company\Company;
use App\Helpers\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Company\CompanyBalance;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Dto\Company\TransactionDto;
use App\Resources\Company\CompanyResource;
use App\Http\Dto\Company\CompanyBalanceDto;
use App\Resources\Payment\PaymentEntityResource;
use App\Models\Company\CompanyBalanceTransaction;
use App\Resources\Company\CompanyBalanceResource;
use App\Exceptions\Company\WrongTransactionException;
use App\Resources\Company\CompanyTransactionResource;
use App\Exceptions\Company\NegativeCompanyBalanceException;
use App\Models\Company\Enums\CompanyBalanceTransactionTypeEnum;

class CompanyBalanceService extends BasicService
{
    use PaginationTrait;
    public function balanceOperation(CompanyBalanceDto $request)
    {
        $user = app('authUser');
        $company = $user->company;
        $companyBalance = $company->companyBalances;
        $transactionDto = new TransactionDto(
            $companyBalanceId = $companyBalance->company_id,
            $currency = $request->currency,
            $amount = $request->amount,
            $type = $request->type,
            $status = $request->status,
            $senderId = null,
            $receiverId = $company->id,
            $paymentMethodId = $request->paymentMethodId
        );
        $transaction = self::createTransaction($transactionDto);
        $companyBalance = self::handleCompanyBalance($companyBalance, $transaction);
        return $companyBalance;
    }

    public function showBalance()
    {
        $user = app('authUser');
        $company = $user->company;
        $companyBalance = $company->companyBalances;
        return new CompanyBalanceResource($companyBalance);
    }

    public function showBalanceOperations()
    {
        $user = app('authUser');
        $company = $user->company;

        $companyBalance = QueryBuilder::for($company->companyBalances->companyBalanceTransactions())->allowedFilters([
            AllowedFilter::exact('type'),
        ])->fastPaginate(config('paginationConfig.COMPANY_TRANSACTIONS'));

        $pagination = $this->paginate($companyBalance);

        $companyBalance = $companyBalance->map(function ($transaction) {
            $receiverId = $transaction->receiver_id;
            $senderId = $transaction->sender_id;

            if (isset($receiverId)) {
                $transaction->receiver = Company::with('companyDetails')->find($receiverId);
            }

            if (isset($senderId)) {
                $transaction->sender =  Company::with('companyDetails')->find($senderId);
            }

            unset($transaction->receiver_id);
            unset($transaction->sender_id);

            return $transaction;
        });

        return array_merge($pagination, CompanyTransactionResource::collection($companyBalance)->toArray(request()));
    }

    public static function createTransaction(TransactionDto $data)
    {
        $companyBalanceTransactionData = [
            'company_balance_id' => $data->companyBalanceId,
            'currency' => $data->currency,
            'amount' => $data->amount,
            'type' => $data->type,
            'status' => $data->status,
            'sender_id' => $data->senderId??null,
            'receiver_id' => $data->receiverId,
            'payment_method_id' => $data->paymentMethodId
        ];

        return new CompanyBalanceTransaction($companyBalanceTransactionData);
    }

    public static function handleCompanyBalance(CompanyBalance $companyBalance, CompanyBalanceTransaction $transaction)
    {
        switch ($transaction->type) {
            case CompanyBalanceTransactionTypeEnum::WITHDRAWAL()->value:
                $companyBalance->balance = $companyBalance->balance - $transaction->amount;
                break;
            case CompanyBalanceTransactionTypeEnum::DEPOSIT()->value:
                $companyBalance->balance = $companyBalance->balance + $transaction->amount;
                break;
            case CompanyBalanceTransactionTypeEnum::SALE()->value:
                $companyBalance->balance = $companyBalance->balance + $transaction->amount;
                break;
            case CompanyBalanceTransactionTypeEnum::PURCHASE()->value:
                $companyBalance->balance = $companyBalance->balance - $transaction->amount;
                break;
        }
        if ($companyBalance->balance < 0) {
            throw (new NegativeCompanyBalanceException());
        }
        $companyBalance->save();
        $transaction->save();
        return $companyBalance;
    }
}
