<?php

namespace App\Http\Controllers\Portal\Company;

use App\Services\Company\CompanyService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(RegisterCompanyDto $request, CompanyService $companyService): JsonResponse
    {
        return $this->ok([$companyService->createCompany($request)]);
    }

    public function index(CompanyService $companyService): JsonResponse
    {
        return $this->ok($companyService->getCompanies());
    }

    public function show(int $id, CompanyService $companyService)
    {
        return $this->ok([$companyService->getCompany($id)]);
    }
}
