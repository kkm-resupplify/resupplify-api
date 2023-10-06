<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country\Country;
use App\Models\User\User;

class CountryController extends Controller
{
    //
    public function index()
    {
        return response()->json(
            [
                'message' => 'Return all countries',
                'data' => Country::all(),
            ]
            );
    }

    public function create(Request $request)
    {
        if($request->input('name') == '' || $request->input('name') == '')
        {
            return response()->json(
                [
                    'message' => 'Return all countries',
                    'data' => Country::all(),
                ]
                );
        }
        Country::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);
    }
}
