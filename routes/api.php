<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\CompanyController as CompanyController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('test', [CompanyCategoryController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
  Route::post('logout', [AuthController::class, 'logout']);
  Route::get('companies', [CompanyController::class, 'getCompanies']);
  Route::get('company/{company_id}', [CompanyController::class, 'getCompany']);
  Route::get('company/{company_id}/roles', [CompanyController::class, 'getCompanyRoles']);
  Route::get('company/{company_id}/members', [CompanyController::class, 'getCompanyMembers']);
  Route::post('company/{company_id}/add-user', [CompanyController::class, 'addUserToCompany']);
  Route::post('company/test', [CompanyController::class, 'test']);
  Route::delete('company/deleteUserFromCompany/{user_id}', [CompanyController::class, 'deleteUserFromCompany']);
  Route::resource('company', CompanyController::class);
});
