<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user->getRoleNames()->first();

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

       if (str_starts_with($role, 'area')) {
    $areaNumber = str_replace('area', '', $role);
    return redirect()->route('dashboard.area', ['area' => $areaNumber]);
}
        return redirect('/'); // default jika role tidak cocok
    }

    return back()
        ->withErrors(['email' => 'Login gagal.'])
        ->onlyInput('email');
}

     public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();          
        $request->session()->regenerateToken();     

        return redirect('/login');                   
    }
} 