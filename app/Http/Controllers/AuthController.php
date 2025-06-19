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
            $user = Auth::user();
            $role = $user->getRoleNames()->first();

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (str_starts_with($role, 'area')) {
                return redirect()->route('manager-area.dashboard', ['area' => $role]);
            }

            return redirect('/');
        }

        return back()->withErrors(['email' => 'Login gagal. Email atau password salah.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}