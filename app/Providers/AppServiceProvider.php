<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Company\CompanyService;
use App\Services\BackOffice\Company\CompanyService as BOCompanyService;
use Illuminate\Contracts\Foundation\Application;
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
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
