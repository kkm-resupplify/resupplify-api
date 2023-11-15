<?php

use App\Http\Controllers\Portal\Company\CompanyMemberController;
use App\Http\Controllers\Portal\Product\ProductCategoryController;
use App\Http\Controllers\Portal\Product\ProductSubcategoryController;
use App\Http\Controllers\Portal\Product\ProductController;
use App\Http\Controllers\Portal\Warehouse\WarehouseController;
use App\Http\Controllers\Portal\Warehouse\WarehouseProductController;
use App\Http\Controllers\Test\TestController as TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\Portal\User\UserController as UserController;
use App\Http\Controllers\Portal\Company\CompanyController;

use App\Http\Controllers\BackOffice\Country\CountryController as CountryController;
use App\Http\Controllers\BackOffice\Company\CompanyCategoryController as CompanyCategoryController;
use App\Http\Controllers\BackOffice\Company\InvitationController as InvitationController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login']);
Route::get('country', [CountryController::class, 'index']);
Route::get('country/{country}', [CountryController::class, 'show']);
Route::get('test/lang', [TestController::class, 'langTest']);


Route::middleware('auth:sanctum')->group(function () {
  Route::get('user', [UserController::class, 'index']);
  Route::post('test', [TestController::class, 'test'])->middleware('hasCompany');
  Route::get('test', [TestController::class, 'roleTest']);
  Route::get('user/company', [CompanyController::class, 'getLoggedUserCompany'])->middleware('hasCompany');
  Route::post('user/userDetails', [UserController::class, 'createUserDetails']);
  Route::put('user/userDetails', [UserController::class, 'editUserDetails']);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('country', [CountryController::class, 'create']);
  Route::post('companyDetails', [CompanyController::class, 'createCompanyDetails']);


  Route::resource('productCategory', ProductCategoryController::class);
  Route::get('productSubcategory', [ProductSubcategoryController::class, 'index']);
});

Route::middleware('auth:sanctum')->prefix('company')->group(function () {
  Route::put('', [CompanyController::class, 'editCompany'])->middleware('hasCompany');
  Route::resource('', CompanyController::class);

  Route::post('createInvitationCode', [InvitationController::class, 'createInvitationCode'])->middleware('hasCompany');
  Route::get('roles', [CompanyController::class, 'getCompanyRoles'])->middleware('hasCompany');
  Route::get('companyMembers', [CompanyMemberController::class, 'getUserCompanyMembers'])->middleware('hasCompany');
  Route::get('companyMembers/{user}', [CompanyMemberController::class, 'getCompanyMembers'])->middleware('hasCompany');
  Route::post('join', [CompanyMemberController::class, 'addUserToCompany']);
  Route::post('leave', [CompanyMemberController::class, 'leaveCompany'])->middleware('hasCompany');
  Route::get('roles/permissions', [CompanyController::class, 'getCompanyRolesPermissions']);
  Route::delete('companyMembers/{user}', [CompanyMemberController::class, 'deleteCompanyMember'])->middleware('hasCompany');
  Route::resource('warehouse', WarehouseController::class)->middleware('hasCompany');
  Route::post('productMassAssign', [ProductController::class, 'massAssignProductsStatus'])->middleware('hasCompany');
  Route::resource('product', ProductController::class)->middleware('hasCompany');
  Route::resource('companyCategories', CompanyCategoryController::class);
  Route::post('warehouse/product', [WarehouseProductController::class, 'store'])->middleware('hasCompany');
  Route::post('warehouse/productMassAssign', [WarehouseProductController::class, 'massAssignProductStatus'])->middleware('hasCompany');
  Route::get('warehouse/{warehouse}/productNotAttached/', [WarehouseProductController::class, 'productsNotInWarehouse'])->middleware('hasCompany');
  Route::delete('warehouse/{warehouse}/product/{product}', [WarehouseProductController::class, 'destroy'])->middleware('hasCompany');
  Route::put('warehouse/{warehouse}/product/{product}', [WarehouseProductController::class, 'update'])->middleware('hasCompany');
  Route::get('warehouse/{warehouse}/product/{product}', [WarehouseProductController::class, 'show'])->middleware('hasCompany');
  Route::get('warehouse/{warehouse}/product', [WarehouseProductController::class, 'index'])->middleware('hasCompany');
});