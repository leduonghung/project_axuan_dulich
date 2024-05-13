<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;

class LanguageConposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\Interfaces\LanguageRepositoryInterface','App\Repositories\LanguageRepository');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('backend.component.topbar', function ($view) {
            $languageRepository = $this->app->make(LanguageRepository::class);
            $language = $languageRepository->getAll(['id','name','flag','current']);
            $language['active']  = $languageRepository->findWhere(['current'=>1],['id','name','flag','current']);
            $view->with('languages', $language);
        });
    }
}
