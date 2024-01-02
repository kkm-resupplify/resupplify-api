<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Services\Company\CompanyService;
use App\Services\BackOffice\Company\CompanyService as BOCompanyService;
use App\Services\BackOffice\Product\ProductService as BOProductService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthService::class, fn() => new AuthService());
        $this->app->singleton(CompanyService::class, fn() => new CompanyService());
        $this->app->singleton(BOCompanyService::class, fn() => new BOCompanyService());
        $this->app->singleton(BOProductService::class, fn() => new BOProductService());
        $this->app->singleton('authUser', function ($app) {
            return Auth::user() ?? request()->user();
        });
        $this->app->singleton('authUserCompany', function ($app) {
            return Auth::user()->company;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
