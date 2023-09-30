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
        return response()->json(
            [
                'message' => 'Returning all companies',
                'data' => Company::all(),
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

    /**
     * Assign user to the company
     */
    private function createCompanyMember(int $userId, int $companyId, int $roleId)
    {
        if (!User::find($userId)) {
            return response()->json(
                [
                    'error' => "There is no user :{$userId}",
                    'message' => 'Something went wrong in CompanyController.createCompanyMember',
                ],
                401
            );
        }
        if (!Company::find($companyId)) {
            return response()->json(
                [
                    'error' => "There is no company :{$companyId}",
                    'message' => 'Something went wrong in CompanyController.createCompanyMember',
                ],
                401
            );
        }
        if (Company::find($companyId)->companyRoles->where('id', '=', $roleId)->isEmpty()) {
            return response()->json(
                [
                    'error' => "There is no role :{$roleId} in this company: {$companyId}",
                    'message' => 'Something went wrong in CompanyController.createCompanyMember',
                ],
                401
            );
        } else {
            return CompanyMember::create([
                'message' => 'User added successfully',
                'user_id' => $userId,
                'company_id' => $companyId,
                'company_role_id' => $roleId,
                'roles' => Company::find($companyId)->companyRoles->where('id', '=', $roleId)->first()
            ]);
        }
    }

    /**
     * Add user to the company
     */
    public function addUserToCompany(Request $request, int $company_id)
    {
        $user = User::where('id', $request->input('user_id'))->first();
        if (!$user) {
            return response()->json(
                [
                    'error' => "There is no user with user_id:{$request->input('user_id')}",
                    'message' => 'Something went wrong in CompanyController.addUserToCompany',
                ],
                401
            );
        }
        if (!Company::find($company_id)) {
            return response()->json(
                [
                    'error' => "There is no company :{$company_id}",
                    'message' => 'Something went wrong in CompanyController.createCompanyMember',
                ],
                401
            );
        }
        if ($user->companyMember) {
            return response()->json(
                [
                    'error' => "This user is already a company member",
                    'message' => 'Something went wrong in CompanyController.addUserToCompany',
                ],
                401
            );
        }
        if (count(Company::find($company_id)->companyMembers) > 6) {
            return response()->json(
                [
                    'error' => "This user can't be added to the Company because it has more than 5 members",
                    'message' => 'Something went wrong in CompanyController.addUserToCompany',
                ],
                401
            );
        }
        return self::createCompanyMember($user->id, $company_id, $request->input('role_id'));
    }

    private function checkRolePermission($user)
    {
    }


    private function checkIfUserDontHaveCompany($user)
    {
        return $user->companyMember ? true : false;
    }

    /**
     * Return roles of the company
     */
    public function getCompanyRoles(int $company_id)
    {
        return response()->json(
            [
                'message' => "Returning company:{$company_id} roles",
                'data' => Company::find($company_id)->companyRoles,
            ],
            200
        );
    }

    /**
     * Return company members
     */
    public function getCompanyMembers(int $company_id)
    {
        return response()->json(
            [
                'message' => "Returning company:{$company_id} members",
                'data' => Company::find($company_id)->companyMembers,
            ],
            200
        );
    }

    /**
     * Delete user from the company
     */
    //TODO: jeśli będzie działał już system rang i uprawnień to przerobić to tak żeby nie sprawdzało nazwy rang tylko ich uprawnienia
    public function deleteUserFromCompany(int $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(
                [
                    'error' => "There is no user with this id:{$user_id}",
                    'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
                ],
                401
            );
        }
        if ($user->id == $this->user->id) {
            return response()->json(
                [
                    'error' => "You cannot delete yourself from the company",
                    'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
                ],
                401
            );
        }
        if ($user->companyMember->company->id != $this->user->companyMember->company->id) {
            return response()->json(
                [
                    'error' => "You cannot delete user that is not in your company",
                    'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
                ],
                401
            );
        }
        if ($this->user->companyMember->companyRole['permission_level'] > 1) {
            return response()->json(
                [
                    'error' => "You don't have permission to delete company members from the company",
                    'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
                ],
                401
            );
        }

        if (
            strtolower($user->companyMember->companyRole['name']) == 'owner' ||
            ($user->companyMember->companyRole['name']) == 'admin' && ($this->user->companyMember->companyRole['name']) == 'admin'
        ) {
            return response()->json(
                [
                    'error' => "You cannot delete user that is higher or equal to your rank in the company",
                    'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
                ],
                401
            );
        }
        $user->companyMember->delete();
        return response()->json(
            [
                'message' => "User deleted successfully",
            ],
            200
        );
    }


    /**
     * Delete role of the company
     */
    // Co jeśli jakiś użytkownik ma tą range
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
