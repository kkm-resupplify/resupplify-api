<?php

namespace App\Http\Controllers\BackOffice\Company;

use App\Models\Company\CompanyCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyCategoryController extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => CompanyCategory::all(),
        ]);
    }

}
