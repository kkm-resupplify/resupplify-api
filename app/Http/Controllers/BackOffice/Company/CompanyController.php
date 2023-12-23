<?php

namespace App\Http\Controllers\BackOffice\Company;

use App\Http\Controllers\Controller;
use App\Http\Dto\Company\CompanyMassVerifyDto;
use App\Services\BackOffice\Company\CompanyService;
use Illuminate\Http\JsonResponse;

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

  public function rejectCompany(CompanyService $companyService, $companyId)
  {

    return $this->ok($companyService->rejectCompany($companyId));
  }

  public function massStatusUpdate(CompanyService $companyService, CompanyMassVerifyDto $statusUpdateDTO)
  {

    return $this->ok($companyService->massStatusUpdate($statusUpdateDTO));
  }
}
