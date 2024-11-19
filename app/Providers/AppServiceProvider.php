<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Support\Facades\View;
use App\Models\Training;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['*'], function ($view) {
            $view->with('userProfile', Auth::user());
            $view->with('siteSetting', SiteSetting::find(1));
        });
    }
}
