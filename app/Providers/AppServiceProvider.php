<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

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
        View::composer('*', function ($view) {
            $user = Auth::user();
            $role = $user?->getRoleNames()->first(); // dari Spatie
            $area = $user?->area;
          $areaUser = Str::after($area, 'area');
            $routeName = Request::route()?->getName();
    
            $activeClass = ($routeName === 'admin.dashboard') 
                ? 'bg-[#146082] text-white' 
                : 'text-[#374957]';
    
            $view->with(compact('user', 'role', 'area', 'areaUser', 'routeName', 'activeClass'));
        });
    }
}
