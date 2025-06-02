<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
    
            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'area_1' => redirect()->route('area1.dashboard'),
                'area_2' => redirect()->route('area2.dashboard'),
                'area_3' => redirect()->route('area3.dashboard'),
                'area_4' => redirect()->route('area4.dashboard'),
                'area_5' => redirect()->route('area5.dashboard'),
                'area_6' => redirect()->route('area6.dashboard'),
                default => redirect('/'),
            };
        }
    
        return $next($request);
    }
    
}
