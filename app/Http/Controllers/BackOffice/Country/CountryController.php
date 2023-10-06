<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Models\Country\Country;

class CountryController extends Controller
{
    //
    public function index()
    {
        return Country::all();
    }

    public function create()
    {
        
    }
}
