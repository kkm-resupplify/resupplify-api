<?php

use App\Http\Controllers\Portal\Company\CompanyUserController;
use App\Http\Controllers\Test\TestController as TestController;
use App\Services\Company\CompanyUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\Portal\User\UserController as UserController;
use App\Http\Controllers\BackOffice\Country\CountryController as CountryController;
use App\Http\Controllers\Portal\Company\CompanyController as CompanyController;
use App\Http\Controllers\BackOffice\Company\CompanyCategoryController as CompanyCategoryController;
use App\Http\Controllers\BackOffice\Company\InvitationController as InvitationController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login']);
// Route::get('test', [CompanyCategoryController::class, 'store']);

Route::get('country', [CountryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('test', [TestController::class,'test'])->middleware('hasCompany');
    Route::get('test', [TestController::class, 'roleTest']);
    Route::get('user/company', [CompanyController::class, 'getLoggedUserCompany'])->middleware('hasCompany');;
    Route::post('user/userDetails', [UserController::class, 'createUserDetails']);
    Route::put('user/userDetails', [UserController::class, 'editUserDetails']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('country', [CountryController::class, 'create']);
    Route::post('companyDetails', [CompanyController::class, 'createCompanyDetails']);
    Route::put('company', [CompanyController::class, 'editCompany']);
    Route::post('company/createInvitationCode' , [InvitationController::class, 'createInvitationCode'])->middleware('hasCompany');;
    Route::get('company/roles', [CompanyController::class, 'getCompanyRoles'])->middleware('hasCompany');;
    Route::get('user/company/users', [CompanyUserController::class, 'getUserCompanyUsers'])->middleware('hasCompany');
    Route::get('company/users/{id}', [CompanyUserController::class, 'getCompanyUsers']);
    Route::post('company/join', [CompanyUserController::class, 'addUserToCompany']);
    Route::get('company/roles/permissions', [CompanyController::class, 'getCompanyRolesPermissions']);
    Route::delete('company/{user}', [CompanyUserController::class, 'deleteUserFromCompany'])->middleware('hasCompany');
    Route::resource('company', CompanyController::class);
    Route::resource('companyCategories', CompanyCategoryController::class);
    //Route::resource('user', UserController::class);
    // Route::post('logout', [AuthController::class, 'logout']);
    // Route::get('companies', [CompanyController::class, 'getCompanies']);
    // Route::get('company/{company_id}', [
    //     CompanyController::class,
    //     'getCompany',
    // ]);
    // Route::get('company/{company_id}/roles', [
    //     CompanyController::class,
    //     'getCompanyRoles',
    // ]);
    // Route::get('company/{company_id}/members', [
    //     CompanyController::class,
    //     'getCompanyMembers',
    // ]);
    // Route::post('company/{company_id}/add-user', [
    //     CompanyController::class,
    //     'addUserToCompany',
    // ]);
    // Route::post('company/test', [CompanyController::class, 'test']);
    // Route::put('user/editUserDetails', [
    //     UserController::class,
    //     'editUserDetails',
    // ]);
    // Route::delete('company/deleteUserFromCompany/{user_id}', [
    //     CompanyController::class,
    //     'deleteUserFromCompany',
    // ]);
});
