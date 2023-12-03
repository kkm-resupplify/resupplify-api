<?php

namespace App\Services\Company;


use App\Http\Dto\Company\CompanyBalanceDto;
use App\Models\Company\CompanyCategory;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\Company;
use App\Models\Company\CompanyBalanceTransactions;
class CompanyBalanceService extends BasicService
{
    public function createTransaction(CompanyBalanceDto $request)
    {
        $user = Auth::user();
        $company = Company::findOrFail($request->companyId);
        return $companyBalance = new CompanyBalanceTransactions(['company_id' => $company->companyBalances->company_id,'amount' => $request->amount,'type' => $request->type]);
    }
}
