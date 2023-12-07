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
use App\Http\Controllers\Portal\Product\ProductTagController;
use App\Http\Controllers\Portal\Product\ProductProductTagController;
use App\Http\Controllers\Portal\Product\ProductUnitController;
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
  Route::post('user/language', [UserController::class, 'language']);
  Route::get('user/company', [CompanyController::class, 'getLoggedUserCompany'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::post('user/userDetails', [UserController::class, 'createUserDetails']);
  Route::put('user/userDetails', [UserController::class, 'editUserDetails']);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('country', [CountryController::class, 'create']);
  Route::post('companyDetails', [CompanyController::class, 'createCompanyDetails']);
  Route::resource('productCategory', ProductCategoryController::class);
  Route::get('productSubcategory', [ProductSubcategoryController::class, 'index']);
  Route::get('productUnit', [ProductUnitController::class, 'index']);
});

Route::middleware(AUTH_SANCTUM_MIDDLEWARE)->prefix('company')->group(function () {
  Route::put('', [CompanyController::class, 'editCompany'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::resource('productTag', ProductTagController::class)->middleware('hasCompany');
  Route::resource('', CompanyController::class);
  Route::resource('productTag/product', ProductProductTagController::class)->middleware('hasCompany');
  Route::post('productTag/product' , [ProductProductTagController::class, 'store'])->middleware('hasCompany');
  Route::delete('productTag/product', [ProductProductTagController::class, 'destroy'])->middleware('hasCompany');
  Route::post('createInvitationCode', [InvitationController::class, 'createInvitationCode'])
    ->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::post('join', [CompanyMemberController::class, 'addUserToCompany']);
  Route::post('leave', [CompanyMemberController::class, 'leaveCompany'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::get('roles', [CompanyController::class, 'getCompanyRoles'])->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::get('roles/permissions', [CompanyController::class, 'getCompanyRolesPermissions']);
  Route::post('productMassAssign', [ProductController::class, 'massAssignProductsStatus'])
    ->middleware(HAS_COMPANY_MIDDLEWARE);
  Route::resource('companyCategories', CompanyCategoryController::class);
});

const WAREHOUSE_PRODUCT_CRUD_ROUTE_SUFFIX = 'warehouse/{warehouse}/product/{product}';

Route::middleware(AUTH_SANCTUM_MIDDLEWARE, HAS_COMPANY_MIDDLEWARE)->prefix('company')->group(function () {
  Route::resource('warehouse', WarehouseController::class);
  Route::post('warehouse/product', [WarehouseProductController::class, 'store']);
  Route::post('warehouse/productMassAssign', [WarehouseProductController::class, 'massAssignProductStatus']);
  Route::get('warehouse/{warehouse}/productNotAttached/', [WarehouseProductController::class, 'productsNotInWarehouse']);
  Route::delete(WAREHOUSE_PRODUCT_CRUD_ROUTE_SUFFIX, [WarehouseProductController::class, 'destroy']);
  Route::put(WAREHOUSE_PRODUCT_CRUD_ROUTE_SUFFIX, [WarehouseProductController::class, 'update']);
  Route::get(WAREHOUSE_PRODUCT_CRUD_ROUTE_SUFFIX, [WarehouseProductController::class, 'show']);
  Route::get('warehouse/{warehouse}/product', [WarehouseProductController::class, 'index']);
  Route::get('product/stats', [ProductController::class, 'productStats']);
  Route::resource('product', ProductController::class);
});


Route::middleware(AUTH_SANCTUM_MIDDLEWARE, HAS_COMPANY_MIDDLEWARE)->prefix('company/companyMembers')
  ->group(function () {
    Route::get('', [CompanyMemberController::class, 'getUserCompanyMembers']);
    Route::get('{user}', [CompanyMemberController::class, 'getCompanyMembers']);
    Route::delete('{user}', [CompanyMemberController::class, 'deleteCompanyMember']);
  });
