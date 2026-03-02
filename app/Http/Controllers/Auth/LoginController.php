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
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Try to log in using email + password
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/shop');
        }

        // If login fails
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }
}
