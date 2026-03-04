<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return inertia('login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Auto-logout seller if logged in
        if (auth('seller')->check()) {
            auth('seller')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Attempt buyer login
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }
}
