<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\CompanyDetails;
use App\Models\CompanyMember;
use App\Models\CompanyRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
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
    public function store(StoreCompanyRequest $request)
    {
        try {
            $user = Auth::user();
            if($user->companyMember)
            {
                return response()->json(
                    [
                        'message' => 'You can only create one company',
                        'data' => $user->companyMember
                    ]
                    );
            }
            $company = Company::create([
                'name' => $request->input('name'),
                'slug' => self::slugify($request->input('name')),
                'description' => $request->input('description'),
                'verificationStatus' => 'pending',
                'user_id' => $user->id,
            ]);
            $companyAbout = CompanyDetails::create([
                'company_id' => $company->id,
            ]);
            $companyRoles = CompanyRole::create([
                'name' => 'admin',
                'permission_level' => 1,
                'company_id' => $company->id,
            ]);
            $companyMember = CompanyMember::create([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'company_role_id' => $companyRoles->id
            ]);
            return response()->json([
                'message' => 'Company created successfully',
                'data' => 
                [
                    'company' => $company,
                    'company_about' => $companyAbout,
                    'company_roles' => $companyRoles,
                    'company_member' => $companyMember
                ]
                ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'message' => 'Something went wrong in CompanyController.store',
                ],
                401
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
