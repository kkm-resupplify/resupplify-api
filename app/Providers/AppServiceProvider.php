<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\BackOffice\Company\CompanyService as BOCompanyService;
use App\Services\BackOffice\Product\ProductService as BOProductService;
use App\Services\Company\CompanyService;
use Illuminate\Support\ServiceProvider;

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

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
