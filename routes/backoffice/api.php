<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as AuthController;

use App\Http\Controllers\BackOffice\Company\CompanyController as BOCompanyController;
use App\Http\Controllers\BackOffice\Product\ProductController as BOProductController;

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
