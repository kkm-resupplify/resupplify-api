<?php

namespace App\Http\Controllers;

use App\Models\CompanyCategory;
use Illuminate\Http\Request;

class CompanyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json([
            'test' => 'Hello, world!',
            'request' => $request,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyCategory $companyCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyCategory $companyCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyCategory $companyCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyCategory $companyCategory)
    {
        //
    }
}
