<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return inertia('seller/register');
    }

    public function register(Request $request)
    {

    $request->validate([
            'name' => 'required',
            'location' => 'required',
            'number' => 'required',
            'slug' => 'required|unique:sellers', // Add the table name
            'email' => 'required|email|unique:sellers,email',
            'password' => 'required|min:6'


        ]);

        $seller = Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'number' => $request->number,
            'slug' => $request->slug,
            'password' => Hash::make($request->password),
            'certification_status' => 'pending',
        ]);

        Auth::guard('seller')->login($seller);

        return redirect('/seller/dashboard');
    }
}