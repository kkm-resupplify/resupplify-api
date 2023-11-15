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

const AUTH_SANCTUM_MIDDLEWARE = 'auth:sanctum';
const HAS_COMPANY_MIDDLEWARE = 'hasCompany';

Route::middleware(AUTH_SANCTUM_MIDDLEWARE)->group(function () {
  Route::get('user', [UserController::class, 'index']);
  Route::post('test', [TestController::class, 'test'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::get('test', [TestController::class, 'roleTest']);
  Route::get('user/company', [CompanyController::class, 'getLoggedUserCompany'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::post('user/userDetails', [UserController::class, 'createUserDetails']);
  Route::put('user/userDetails', [UserController::class, 'editUserDetails']);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('country', [CountryController::class, 'create']);
  Route::post('companyDetails', [CompanyController::class, 'createCompanyDetails']);
  Route::resource('productCategory', ProductCategoryController::class);
  Route::get('productSubcategory', [ProductSubcategoryController::class, 'index']);
});

Route::middleware(AUTH_SANCTUM_MIDDLEWARE)->prefix('company')->group(function () {
  Route::put('', [CompanyController::class, 'editCompany'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::resource('', CompanyController::class);
  Route::post('createInvitationCode', [InvitationController::class, 'createInvitationCode'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::post('join', [CompanyMemberController::class, 'addUserToCompany']);
  Route::post('leave', [CompanyMemberController::class, 'leaveCompany'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::get('roles', [CompanyController::class, 'getCompanyRoles'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::get('roles/permissions', [CompanyController::class, 'getCompanyRolesPermissions']);
  Route::post('productMassAssign', [ProductController::class, 'massAssignProductsStatus'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::resource('companyCategories', CompanyCategoryController::class);
});

Route::middleware(AUTH_SANCTUM_MIDDLEWARE, HAS_COMPANY_MIDDLEWARE)->prefix('company/warehouse')->group(function () {
  Route::resource('', WarehouseController::class);
  Route::post('product', [WarehouseProductController::class, 'store']);
  Route::post('productMassAssign', [WarehouseProductController::class, 'massAssignProductStatus']);
  Route::get('{warehouse}/productNotAttached/', [WarehouseProductController::class, 'productsNotInWarehouse']);
  Route::delete('{warehouse}/product/{product}', [WarehouseProductController::class, 'destroy']);
  Route::put('{warehouse}/product/{product}', [WarehouseProductController::class, 'update']);
  Route::get('{warehouse}/product/{product}', [WarehouseProductController::class, 'show']);
  Route::get('{warehouse}/product', [WarehouseProductController::class, 'index']);
});

Route::middleware(AUTH_SANCTUM_MIDDLEWARE, HAS_COMPANY_MIDDLEWARE)->prefix('company/product')->group(function () {
  Route::resource('', ProductController::class);
});

Route::middleware(AUTH_SANCTUM_MIDDLEWARE, HAS_COMPANY_MIDDLEWARE)->prefix('company/companyMembers')->group(function () {
  Route::get('', [CompanyMemberController::class, 'getUserCompanyMembers']);
  Route::get('{user}', [CompanyMemberController::class, 'getCompanyMembers']);
  Route::delete('{user}', [CompanyMemberController::class, 'deleteCompanyMember']);
});
