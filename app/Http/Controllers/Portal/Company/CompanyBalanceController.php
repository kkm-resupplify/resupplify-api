<?php

namespace App\Http\Controllers\Portal\Company;

use App\Http\Controllers\Controller;
use App\Http\Dto\Company\CompanyBalanceDto;
use App\Services\Company\CompanyBalanceService;


class CompanyBalanceController extends Controller
{
    public function store(CompanyBalanceDto $request, CompanyBalanceService $companyBalanceService)
    {
        return $this->ok($companyBalanceService->balanceOperation($request));
    }

    public function index(CompanyBalanceService $companyBalanceService)
    {
        return $this->ok($companyBalanceService->showBalance());
    }

    public function showBalanceOperations(CompanyBalanceService $companyBalanceService)
    {
        return $this->ok($companyBalanceService->showBalanceOperations());
    }

}
