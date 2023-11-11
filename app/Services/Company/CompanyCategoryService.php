<?php

namespace App\Services\Company;


use App\Models\Company\CompanyCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CompanyCategoryService extends Controller
{
    public function getCategories()
    {
        $categories = CompanyCategory::all();
        return $categories;
    }
}
