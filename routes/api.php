<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\CompanyCategoryController as CompanyCategoryController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('test', [CompanyCategoryController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {});
