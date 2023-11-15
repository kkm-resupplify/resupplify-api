<?php

use App\Http\Controllers\Portal\Company\CompanyMemberController;
use App\Http\Controllers\Portal\Product\ProductCategoryController;
use App\Http\Controllers\Portal\Product\ProductSubcategoryController;
use App\Http\Controllers\Portal\Product\ProductController;
use App\Http\Controllers\Portal\Warehouse\WarehouseController;
use App\Http\Controllers\Portal\Warehouse\WarehouseProductController;
use App\Http\Controllers\Test\TestController as TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\Portal\User\UserController as UserController;
use App\Http\Controllers\Portal\Company\CompanyController;

use App\Http\Controllers\BackOffice\Country\CountryController as CountryController;
use App\Http\Controllers\BackOffice\Company\CompanyCategoryController as CompanyCategoryController;
use App\Http\Controllers\BackOffice\Company\InvitationController as InvitationController;
use App\Http\Controllers\BackOffice\Company\CompanyController as BOCompanyController;
use App\Http\Controllers\BackOffice\Product\ProductController as BOProductController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login']);
Route::get('country', [CountryController::class, 'index']);
Route::get('country/{country}', [CountryController::class, 'show']);
Route::get('test/lang', [TestController::class, 'langTest']);

// Back office
Route::prefix('back-office')->group(function () {
    Route::post('/login', [AuthController::class, 'backOfficeLogin']);
    Route::post('/register', [AuthController::class, 'backOfficeRegister'])->name('backOfficeRegister');
});

Route::middleware('auth:sanctum', 'isBackOfficeAdmin')->prefix('back-office')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/company', [BOCompanyController::class, 'index']);
    Route::get('/company/verify', [BOCompanyController::class, 'unverifiedCompanies']);
    Route::post('/company/massStatusUpdate', [BOCompanyController::class, 'massStatusUpdate']);
    Route::put('/company/verify/{companyId}', [BOCompanyController::class, 'verifyCompany']);
    Route::put('/company/reject/{companyId}', [BOCompanyController::class, 'rejectCompany']);

    Route::get('/product', [BOProductController::class, 'index']);
    Route::get('/product/verify', [BOProductController::class, 'unverifiedProducts']);
    Route::post('/product/massStatusUpdate', [BOProductController::class, 'massStatusUpdate']);
    Route::put('/product/verify/{productId}', [BOProductController::class, 'verifyProduct']);
    Route::put('/product/reject/{productId}', [BOProductController::class, 'rejectProduct']);
});

// Portal
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'index']);
    Route::post('test', [TestController::class, 'test'])->middleware('hasCompany');
    Route::get('test', [TestController::class, 'roleTest']);
    Route::get('user/company', [CompanyController::class, 'getLoggedUserCompany'])->middleware('hasCompany');;
    Route::post('user/userDetails', [UserController::class, 'createUserDetails']);
    Route::put('user/userDetails', [UserController::class, 'editUserDetails']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('country', [CountryController::class, 'create']);
    Route::post('companyDetails', [CompanyController::class, 'createCompanyDetails']);
    Route::put('company', [CompanyController::class, 'editCompany'])->middleware('hasCompany');
    Route::post('company/createInvitationCode', [InvitationController::class, 'createInvitationCode'])->middleware('hasCompany');
    Route::get('company/roles', [CompanyController::class, 'getCompanyRoles'])->middleware('hasCompany');
    Route::get('company/companyMembers', [CompanyMemberController::class, 'getUserCompanyMembers'])->middleware('hasCompany');
    Route::get('company/companyMembers/{user}', [CompanyMemberController::class, 'getCompanyMembers'])->middleware('hasCompany');
    Route::post('company/join', [CompanyMemberController::class, 'addUserToCompany']);
    Route::post('company/leave', [CompanyMemberController::class, 'leaveCompany'])->middleware('hasCompany');
    Route::get('company/roles/permissions', [CompanyController::class, 'getCompanyRolesPermissions']);
    Route::delete('company/companyMembers/{user}', [CompanyMemberController::class, 'deleteCompanyMember'])->middleware('hasCompany');
    Route::resource('company/warehouse', WarehouseController::class)->middleware('hasCompany');
    Route::post('company/productMassAssign', [ProductController::class, 'massAssignProductsStatus'])->middleware('hasCompany');
    Route::resource('company/product', ProductController::class)->middleware('hasCompany');
    Route::resource('company', CompanyController::class);
    Route::resource('companyCategories', CompanyCategoryController::class);
    Route::post('company/warehouse/product', [WarehouseProductController::class, 'store'])->middleware('hasCompany');
    Route::post('company/warehouse/productMassAssign', [WarehouseProductController::class, 'massAssignProductStatus'])->middleware('hasCompany');
    Route::get('company/warehouse/{warehouse}/productNotAttached/', [WarehouseProductController::class, 'productsNotInWarehouse'])->middleware('hasCompany');
    Route::delete('company/warehouse/{warehouse}/product/{product}', [WarehouseProductController::class, 'destroy'])->middleware('hasCompany');
    Route::put('company/warehouse/{warehouse}/product/{product}', [WarehouseProductController::class, 'update'])->middleware('hasCompany');
    Route::get('company/warehouse/{warehouse}/product/{product}', [WarehouseProductController::class, 'show'])->middleware('hasCompany');
    Route::get('company/warehouse/{warehouse}/product', [WarehouseProductController::class, 'index'])->middleware('hasCompany');
    Route::resource('productCategory', ProductCategoryController::class);
    //Route::get('productCategory', [ProductCategoryController::class, 'index']);
    Route::get('productSubcategory', [ProductSubcategoryController::class, 'index']);
});
