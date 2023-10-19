<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\Portal\User\UserController as UserController;
use App\Http\Controllers\BackOffice\Country\CountryController as CountryController;
use App\Http\Controllers\Portal\Company\CompanyController as CompanyController;
use App\Http\Controllers\BackOffice\Company\CompanyCategoryController as CompanyCategoryController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login']);
// Route::get('test', [CompanyCategoryController::class, 'store']);

Route::get('country', [CountryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('company', CompanyController::class);
    Route::post('user/userDetails', [UserController::class, 'createUserDetails']);
    Route::put('user/userDetails', [UserController::class, 'editUserDetails']);
    Route::post('companyDetails', [CompanyController::class, 'createCompanyDetails']);
    Route::post('country', [CountryController::class, 'create']);
    Route::post('createInvitationCode' , [InvitationCodeController::class, 'createInvitationCode']);
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
