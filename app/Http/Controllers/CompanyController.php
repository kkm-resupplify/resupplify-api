<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\CompanyDetails;
use App\Models\CompanyMember;
use App\Models\CompanyRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class CompanyController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
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
        if ($this->user == null) {
            return response()->json(
                [
                    'error' => 'no company found',
                    'message' => 'Something went wrong in CompanyController.index',
                ],
                401
            );
        }
        return response()->json(
            [
                'message' => 'Company info',
                'data' => $this->user
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
        if ($this->checkIfUserDontHaveCompany($this->user)) {
            return response()->json(
                [
                    'message' => 'You can only create one company',
                    'data' => $this->user->companyMember
                ]
            );
        }
        try {
            $company = $this->createCompany($request);
            $companyAbout = $this->createCompanyDetails($company->id);
            $companyRoles = $this->createCompanyRoles($company->id);
            $companyMember = $this->createCompanyMember($this->user->id, $company->id, $companyRoles->id);

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
    private function createCompany($request)
    {
        return Company::create([
            'name' => $request->input('name'),
            'slug' => self::slugify($request->input('name')),
            'description' => $request->input('description'),
            'verificationStatus' => 'pending',
            'user_id' => $this->user->id,
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
     * Get all companies
     */
    public function getCompanies()
    {
        $companies = Company::all();
        if($companies->isEmpty())
        {
            return response()->json(
                [
                    'error' => "No companies found",
                    'message' => 'Something went wrong in CompanyController.getCompanies',
                ],
                401
            );
        }
        return response()->json(
            [
                'message' => 'Returning all companies',
                'data' => $companies,
            ],
            200
        );
    }

    public function getCompany(int $company_id)
    {
        $company = Company::find($company_id)->first();
        if (!$company) {
            return response()->json(
                [
                    'error' => "There is no company with company_id:{$company_id}",
                    'message' => 'Something went wrong in CompanyController.getCompany',
                ],
                401
            );
        }
        return response()->json(
            [
                'message' => 'Returning company',
                'data' => Company::find($company_id),
            ],
            200
        );
    }
    /**
     * Create company basic roles
     * @param int $companyId
     * @return CompanyRole
     */
    private function createCompanyRoles(int $companyId)
    {
        $roles = ['owner', 'admin', 'worker'];
        $ownerRole = null;

        foreach ($roles as $role) {
            $newRole = CompanyRole::create([
                'name' => $role,
                'permission_level' => 1,
                'company_id' => $companyId,
            ]);

            if ($role === 'owner') {
                $ownerRole = $newRole;
            }
        }

        return $ownerRole;
    }

    

    

    private function checkRolePermission($user)
    {
    }


   

    /**
     * Return roles of the company
     */
    public function getCompanyRoles(int $company_id)
    {
        if(!Company::find($company_id))
        {
            return response()->json(
                [
                    'error' => "Company not found",
                    'message' => 'Something went wrong in CompanyController.getCompanyRoles',
                ],
                401
            );
        }
        $roles = Company::find($company_id)->companyRoles;
        if($roles->isEmpty())
        {
            return response()->json(
                [
                    'error' => "No roles were found for company {$company_id}",
                    'message' => 'Something went wrong in CompanyController.getCompanyRoles',
                ],
                401
            );
        }
        return response()->json(
            [
                'message' => "Returning company:{$company_id} roles",
                'data' => Company::find($company_id)->companyRoles,
            ],
            200
        );
    }



    


    /**
     * Delete role of the company
     */
    // Co jeśli jakiś użytkownik ma tą range
    public function deleteRoleFromCompany($role_id)
    {
        $role = User::find($role_id);
        if (!$role) {
            return response()->json(
                [
                    'error' => "There is no role with this id:{$role}",
                    'message' => 'Something went wrong in CompanyController.deleteRoleFromCompany',
                ],
                401
            );
        }
        if ($this->user->companyMember->company['id'] != $role->company['id']) {
            return response()->json(
                [
                    'error' => "You cannot delete roles not from your company",
                    'message' => 'Something went wrong in CompanyController.deleteRoleFromCompany',
                ],
                401
            );
        }
        if ($this->user->companyMember->companyRole['permission_level'] > 1) {
            return response()->json(
                [
                    'error' => "You don't have permission to delete roles from the company",
                    'message' => 'Something went wrong in CompanyController.deleteRoleFromCompany',
                ],
                401
            );
        }
        if(strtolower($this->user->companyMember->companyRole['name']) == 'owner')
        {
            return response()->json(
                [
                    'error' => "You can't delete owner role from the company",
                    'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
                ],
                401
            );
        }
        return $this->user->companyMember->companyRole;
        $role->delete();
        return response()->json(
            [
                'message' => "Role deleted successfully",
            ],
            200
        );
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

    public function test(Request $request)
    {
        if (!Company::find($request->input('company_id'))->companyRoles->where('id', '=', $request->input('role_id'))) {
            return response()->json(
                [
                    'message' => 'destroy'
                ]
            );
        }
        return response()->json(
            [
                'message' => 'xdy'
            ]
        );
    }
}
