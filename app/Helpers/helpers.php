<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($routeName, $activeClass = 'bg-[#146082] text-white', $inactiveClass = 'text-[#374957]') {
        return Route::is($routeName) ? $activeClass : $inactiveClass;
    }
}
