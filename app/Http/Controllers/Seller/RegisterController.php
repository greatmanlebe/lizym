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
        $seller = Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'number' => $request->number,
            'slug' => $request->slug,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('seller')->login($seller);

        return redirect('/seller/dashboard');
    }
}