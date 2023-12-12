<?php

namespace App\Http\Controllers\Portal\Company;

use App\Http\Controllers\Controller;
use App\Http\Dto\Company\CompanyTransactionDto;
use App\Services\Company\CompanyBalanceService;


class CompanyBalanceController extends Controller
{
    public function store(CompanyTransactionDto $request, CompanyBalanceService $companyBalanceService)
    {
        return $this->ok($companyBalanceService->createTransaction($request));
    }

}
