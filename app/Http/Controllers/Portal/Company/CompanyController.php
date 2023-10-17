<?php

namespace App\Http\Controllers\Portal\Company;

use App\Services\Company\CompanyService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;

class CompanyController extends Controller
{
    public function store(RegisterCompanyDto $request, CompanyService $companyService): JsonResponse
    {
        return $this->ok([$companyService->createCompany($request)]);
    }

    //TODO: Return CompanyResource ($company,$companyDetails)
    // public function index()
    // {
    //     return $this->ok(
    // }
}
