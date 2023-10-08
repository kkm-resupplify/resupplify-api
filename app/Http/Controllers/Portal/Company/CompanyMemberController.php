<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class CompanyMemberController extends Controller
// {
//     /**
//      * Assign user to the company
//      */
//     private function createCompanyMember(int $userId, int $companyId, int $roleId)
//     {
//         if (!User::find($userId)) {
//             return response()->json(
//                 [
//                     'error' => "There is no user :{$userId}",
//                     'message' => 'Something went wrong in CompanyController.createCompanyMember',
//                 ],
//                 401
//             );
//         }
//         if (!Company::find($companyId)) {
//             return response()->json(
//                 [
//                     'error' => "There is no company :{$companyId}",
//                     'message' => 'Something went wrong in CompanyController.createCompanyMember',
//                 ],
//                 401
//             );
//         }
//         $role = Company::find($companyId)->companyRoles->where('id', '=', $roleId)->first();
//         if (!$role) {
//             return response()->json(
//                 [
//                     'error' => "There is no role :{$roleId} in this company: {$companyId}",
//                     'message' => 'Something went wrong in CompanyController.createCompanyMember',
//                 ],
//                 401
//             );
//         }
//         if (strtolower($role->name) == 'owner') {
//             return response()->json(
//                 [
//                     'error' => "There can be only one owner in company",
//                     'message' => 'Something went wrong in CompanyController.createCompanyMember',
//                 ],
//                 401
//             );
//         }
//         return CompanyMember::create([
//             'user_id' => $userId,
//             'company_id' => $companyId,
//             'company_role_id' => $roleId,
//             'roles' => $role
//         ]);
//     }

    // /**
    //  * Add user to the company
    //  */
    // public function addUserToCompany(Request $request, int $company_id)
    // {
    //     $user = User::where('id', $request->input('user_id'))->first();
    //     if (!$user) {
    //         return response()->json(
    //             [
    //                 'error' => "There is no user with user_id:{$request->input('user_id')}",
    //                 'message' => 'Something went wrong in CompanyController.addUserToCompany',
    //             ],
    //             401
    //         );
    //     }
    //     if (!Company::find($company_id)) {
    //         return response()->json(
    //             [
    //                 'error' => "There is no company :{$company_id}",
    //                 'message' => 'Something went wrong in CompanyController.createCompanyMember',
    //             ],
    //             401
    //         );
    //     }
    //     if ($user->companyMember) {
    //         return response()->json(
    //             [
    //                 'error' => "This user is already a company member",
    //                 'message' => 'Something went wrong in CompanyController.addUserToCompany',
    //             ],
    //             401
    //         );
    //     }
    //     if (count(Company::find($company_id)->companyMembers) > 6) {
    //         return response()->json(
    //             [
    //                 'error' => "This user can't be added to the Company because it has more than 5 members",
    //                 'message' => 'Something went wrong in CompanyController.addUserToCompany',
    //             ],
    //             401
    //         );
    //     }
    //     return self::createCompanyMember($user->id, $company_id, $request->input('role_id'));
    // }

//     private function checkIfUserDontHaveCompany($user)
//     {
//         return $user->companyMember ? true : false;
//     }

//     /**
//      * Return company members
//      */
//     public function getCompanyMembers(int $company_id)
//     {
//         return response()->json(
//             [
//                 'message' => "Returning company:{$company_id} members",
//                 'data' => Company::find($company_id)->companyMembers,
//             ],
//             200
//         );
//     }

//     /**
//      * Delete user from the company
//      */
//     //TODO: jeśli będzie działał już system rang i uprawnień to przerobić to tak żeby nie sprawdzało nazwy rang tylko ich uprawnienia
//     public function deleteUserFromCompany(int $user_id)
//     {
//         $user = User::find($user_id);
//         if (!$user) {
//             return response()->json(
//                 [
//                     'error' => "There is no user with this id:{$user_id}",
//                     'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
//                 ],
//                 401
//             );
//         }
//         if ($user->id == $this->user->id) {
//             return response()->json(
//                 [
//                     'error' => "You cannot delete yourself from the company",
//                     'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
//                 ],
//                 401
//             );
//         }
//         if ($user->companyMember->company->id != $this->user->companyMember->company->id) {
//             return response()->json(
//                 [
//                     'error' => "You cannot delete user that is not in your company",
//                     'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
//                 ],
//                 401
//             );
//         }
//         if ($this->user->companyMember->companyRole['permission_level'] > 1) {
//             return response()->json(
//                 [
//                     'error' => "You don't have permission to delete company members from the company",
//                     'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
//                 ],
//                 401
//             );
//         }
//         if (strtolower($user->companyMember->companyRole['name']) == 'owner') {
//             return response()->json(
//                 [
//                     'error' => "You can't delete owner of the company",
//                     'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
//                 ],
//                 401
//             );
//         }
//         if (
//             strtolower($user->companyMember->companyRole['name']) == 'owner' ||
//             ($user->companyMember->companyRole['name']) == 'admin' && ($this->user->companyMember->companyRole['name']) == 'admin'
//         ) {
//             return response()->json(
//                 [
//                     'error' => "You cannot delete user that is higher or equal to your rank in the company",
//                     'message' => 'Something went wrong in CompanyController.deleteUserFromCompany',
//                 ],
//                 401
//             );
//         }
//         $user->companyMember->delete();
//         return response()->json(
//             [
//                 'message' => "User deleted successfully",
//             ],
//             200
//         );
//     }
// }
