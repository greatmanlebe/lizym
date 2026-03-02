<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return inertia('seller/login');
    }

    public function login(Request $request)
    {
        if (Auth::guard('seller')->attempt($request->only('email', 'password'))) {
            return redirect('/seller/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }
}