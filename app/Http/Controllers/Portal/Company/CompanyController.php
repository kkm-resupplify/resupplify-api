<?php

namespace App\Http\Controllers\Portal\Company;

use Illuminate\Http\Request;
use App\Models\Company\Company;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Company\CompanyService;
use App\Resources\Company\CompanyResource;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;

class CompanyController extends Controller
{
    public function store(RegisterCompanyDto $request, CompanyService $companyService): JsonResponse
    {
        return $this->ok($companyService->createCompany($request));
    }

    public function index(CompanyService $companyService): JsonResponse
    {
        return $this->ok($companyService->getCompanies());
    }

    public function getCompanyRoles(CompanyService $companyService)
    {
        return $this->ok($companyService->getCompanyRoles());
    }

    public function getLoggedUserCompany(CompanyService $companyService): JsonResponse
    {
        return $this->ok($companyService->getUserCompany());
    }

    public function getCompanyRolesPermissions(CompanyService $companyService): JsonResponse
    {
        return $this->ok($companyService->getCompanyRolesPermissions());
    }

    public function editCompany(RegisterCompanyDetailsDto $companyDetailsRequest, RegisterCompanyDto $companyRequest, CompanyService $companyService, Request $request): JsonResponse
    {
        return $this->ok($companyService->editCompany($companyDetailsRequest, $companyRequest, $request));
    }

    public function show($slugOrId, CompanyService $companyService): JsonResponse
    {
        $company = Company::where('id', $slugOrId)
        ->orWhere('slug', $slugOrId)
        ->firstOrFail();

        return $this->ok($companyService->returnCompany($company));
    }
}
