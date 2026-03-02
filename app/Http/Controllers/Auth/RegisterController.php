<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return inertia('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'number' => 'required',
            'email' => 'required|email|unique:buyers,email',
            'password' => 'required|min:6'
        ]);

        $buyer = Buyer::create([
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'number' => $request->number,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($buyer);

        return redirect('/shop');
    }
}