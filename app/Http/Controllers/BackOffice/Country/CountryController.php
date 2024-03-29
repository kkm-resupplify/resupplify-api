<?php

namespace App\Http\Controllers\BackOffice\Country;

use App\Http\Controllers\Controller;
use App\Http\Dto\Country\CountryDto;
use App\Models\Country\Country;

class CountryController extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Country::all(),
        ]);
    }

    public function show(Country $country)
    {
        return response()->json([
          'success' => true,
            'data' => $country,
        ]);
    }

    public function create(CountryDto $request)
    {
        $country = Country::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return response()->json(
            [
                'success' => true,
                'data' => $country,
            ],
            201
        );
    }
}
