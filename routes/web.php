<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\SellerregisterController;
use App\Http\Controllers\Auth\SellerloginController;

use App\Models\Product;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Shop', [
        'products' => Product::all(),
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Home');
});


/*
|--------------------------------------------------------------------------
| BUYER AUTH
|--------------------------------------------------------------------------
*/

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show']);
Route::post('/login', [LoginController::class, 'login']);


/*
|--------------------------------------------------------------------------
| BUYER PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/shop', function () {
        return Inertia::render('Shop', [
            'products' => Product::all(),
        ]);
    });
});


/*
|--------------------------------------------------------------------------
| SELLER AUTH + DASHBOARD + PRODUCT MANAGEMENT
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Seller\RegisterController as SellerRegister;
use App\Http\Controllers\Seller\LoginController as SellerLogin;


Route::prefix('seller')->group(function () {

    // Seller Register
    Route::get('/register', [SellerRegister::class, 'show']);
    Route::post('/register', [SellerRegister::class, 'register']);

    // Seller Login
    Route::get('/login', [SellerLogin::class, 'show']);
    Route::post('/login', [SellerLogin::class, 'login']);

    // Protected seller routes
    Route::middleware('auth:seller')->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return inertia('seller/Dashboard', [
                'products' => Product::where('seller_id', auth('seller')->id())->get(),
            ]);
        });

        // Add product page
        Route::get('/products/create', function () {
            return inertia('seller/Addproducts');
        });

        // Store product
        Route::post('/products', function (Request $request) {
            Product::create([
                'seller_id' => auth('seller')->id(),
                'name' => $request->name,
                'price' => $request->price,
                'image' => $request->image,
                'category' => $request->category,
                'description' => $request->description,
            ]);

        return redirect('/seller/dashboard')->with('message', 'Product added successfully!');
        });

        // Delete product
    Route::delete('/products/{id}', function ($id) {
        $product = Product::findOrFail($id);

    if ($product->seller_id != auth('seller')->id()) {
        return redirect('/seller/dashboard')->withErrors([
            'delete' => 'You cannot delete this product.',
        ]);
    }
        $product->delete();

        return redirect('/seller/dashboard')->with('message', 'Product deleted successfully!');
    });

    });

    
});
    //each seller page
    Route::get('/shop/{seller}', function ($sellerId) {
    $seller = \App\Models\Seller::findOrFail($sellerId);

    $products = \App\Models\Product::where('seller_id', $sellerId)->get();

    return inertia('shop/Sellershop', [
        'seller' => $seller,
        'products' => $products,
    ]);
});