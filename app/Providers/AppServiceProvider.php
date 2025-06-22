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
        $role = $user?->getRoleNames()->first();
        $area = $user?->area;
        $areaId = $user?->area_id;
        $areaUser = Str::after($area, 'area');
        $routeName = Request::route()?->getName();

        // Sidebar aktif indikator
        $indikatorActive = Str::startsWith($routeName, 'indikator.') || Str::startsWith($routeName, 'manager-area.indikator');

        // Sidebar aktif dashboard
        $dashboardActive = $routeName === ($role === 'admin' ? 'admin.dashboard' : 'manager-area.dashboard');

        $view->with(compact(
            'user', 'role', 'area', 'areaId', 'areaUser', 'routeName',
            'indikatorActive', 'dashboardActive'
        ));
    });
}
}
