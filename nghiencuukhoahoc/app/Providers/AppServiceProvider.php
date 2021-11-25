<?php

namespace App\Providers;

use Dotenv\Validator;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        
        // Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
        //     return Hash::check($value, Auth::user()->password);
        // });
        
    }
}
