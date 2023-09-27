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
    public function __construct()
    {
        $this->middleware('auth');
    }


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
        $user = Auth::user();
        return response()->json(
            [
                'message' => 'Company info',
                'data' => $user->companyMember->company
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->json(
            [
                'message' => 'create'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $user = Auth::user();
        if ($user->companyMember) {
            return response()->json(
                [
                    'message' => 'You can only create one company',
                    'data' => $user->companyMember
                ]
            );
        }

        try {
            $company = $this->createCompany($request, $user);
            $companyAbout = $this->createCompanyDetails($company->id);
            $companyRoles = $this->createCompanyRoles($company->id);
            $companyMember = $this->createCompanyMember($user->id, $company->id, $companyRoles->id);

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
     * Create a new company
     */
    private function createCompany($request, $user)
    {
        return Company::create([
            'name' => $request->input('name'),
            'slug' => self::slugify($request->input('name')),
            'description' => $request->input('description'),
            'verificationStatus' => 'pending',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Create company basic details
     * @param int $companyId
     * @return CompanyDetails
     */
    private function createCompanyDetails($companyId)
    {
        return CompanyDetails::create([
            'company_id' => $companyId,
        ]);
    }

    /**
     * Create company basic roles
     * @param int $companyId
     * @return CompanyRole
     */
    private function createCompanyRoles($companyId)
    {
        $ownerRole = CompanyRole::create([
            'name' => 'owner',
            'permission_level' => 1,
            'company_id' => $companyId,
        ]);

        CompanyRole::create([
            'name' => 'admin',
            'permission_level' => 1,
            'company_id' => $companyId,
        ]);

        CompanyRole::create([
            'name' => 'worker',
            'permission_level' => 1,
            'company_id' => $companyId,
        ]);

        return $ownerRole;
    }

    /**
     * Assign owner to the company 
     * @param int $userId
     * @param int $companyId
     * @param int $roleId
     * @return CompanyMember
     */
    private function createCompanyMember($userId, $companyId, $roleId)
    {
        return CompanyMember::create([
            'user_id' => $userId,
            'company_id' => $companyId,
            'company_role_id' => $roleId
        ]);
    }

    /**
     * Add user to the company
     */
    public function addUserToCompany()
    {
    }

    /**
     * Return roles of the company
     */
    public function getCompanyRoles()
    {
    }

    /**
     * Delete user from the company
     */
    public function deleteUserFromCompany()
    {
    }

    /**
     * Delete role of the company
     */
    public function deleteRoleFromCompany()
    {
    }

    /**
     * Edit role of the company
     */
    public function editRoleFromCompany()
    {
    }

    /**
     * Edit company information
     */
    public function editCompanyInformation()
    {
    }

    /**
     * Delete company
     */
    public function deleteCompany()
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
        return response()->json(
            [
                'message' => 'show'
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
        return response()->json(
            [
                'message' => 'edit'
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //
        return response()->json(
            [
                'message' => 'update'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
        return response()->json(
            [
                'message' => 'destroy'
            ]
        );
    }
}
