<?php

namespace App\Http\Controllers\BackOffice\Language;

use App\Http\Controllers\Controller;
use App\Http\Dto\Country\CountryDto;
use App\Models\Country\Country;
use App\Models\Language\Language;

class LanguageController extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Language::all(),
        ]);
    }
}
