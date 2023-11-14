<?php

namespace App\Http\Controllers\BackOffice\Company;

use App\Models\Company\CompanyCategory;
use App\Services\Company\CompanyCategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyCategoryController extends Controller
{

    public function index(CompanyCategoryService $companyCategory)
    {
        return $this->ok($companyCategory->getCategories());
    }

    public function unverifiedCompanies(CompanyCategoryService $companyCategory)
    {
        return $this->ok($companyCategory->getUnverifiedCompanies());
    }
}
