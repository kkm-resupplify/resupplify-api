<?php

namespace App\Http\Controllers\BackOffice\Company;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

use App\Models\Company\Company;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Services\BackOffice\Company\CompanyService;

class CompanyController extends Controller
{
  public function index(CompanyService $companyService): JsonResponse
  {
    return $this->ok($companyService->getCompanies());
  }

  public function unverifiedCompanies(CompanyService $companyService)
  {
    return $this->ok($companyService->getUnverifiedCompanies());
  }

  public function verifiedCompanies(CompanyService $companyService)
  {
    return $this->ok($companyService->getVerifiedCompanies());
  }

  public function verifyCompany(CompanyService $companyService, $companyId)
  {

    return $this->ok($companyService->verifyCompany($companyId));
  }
}
