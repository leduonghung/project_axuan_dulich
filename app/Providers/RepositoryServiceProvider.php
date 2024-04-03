<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\Interfaces\UserServiceInterface::class, \App\Services\UserService::class);
        $this->app->bind(\App\Services\Interfaces\LanguageServiceInterface::class, \App\Services\LanguageService::class);
        $this->app->bind(\App\Services\Interfaces\PostCatalogueServiceInterface::class, \App\Services\PostCatalogueService::class);

        $this->app->bind(\App\Repositories\Interfaces\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\ProvinceRepositoryInterface::class, \App\Repositories\ProvinceRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\DistrictRepositoryInterface::class, \App\Repositories\DistrictRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\LanguageRepositoryInterface::class, \App\Repositories\LanguageRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\PostCatalogueRepositoryInterface::class, \App\Repositories\PostCatalogueRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
