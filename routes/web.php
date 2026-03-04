<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Http\Controllers\Seller\SellerInboxController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;


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
Route::get('/login', [LoginController::class, 'show'])->name('login');



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

/// Buyer starts chat from checkout
Route::post('/checkout/start-chat', [ChatController::class, 'startChat'])
    ->middleware('auth:web')
    ->name('checkout.start-chat');

// Buyer chat list
Route::middleware('auth:web')->get('/chat/chats', function () {
    $buyer = auth('web')->user();

    $conversations = Conversation::with([
        'seller',
        'messages' => function ($q) {
            $q->latest()->limit(1);
        }
    ])
    ->where('buyer_id', $buyer->id)
    ->orderBy('updated_at', 'desc')
    ->get()
    ->map(function ($c) {
        $c->last_message = $c->messages->first();
        return $c;
    });

    return inertia('chat/Chats', [
        'conversations' => $conversations,
    ]);
})->name('chat.chats');

// Shared conversation view + send
Route::get('/chat/{conversation}', [ChatController::class, 'show'])
    ->name('chat.show');

Route::post('/chat/{conversation}/message', [ChatController::class, 'send'])
    ->name('chat.send');

// Seller inbox
Route::middleware('auth:seller')->get('/seller/inbox', [SellerInboxController::class, 'index'])
    ->name('seller.inbox');

// Universal chat button
Route::get('/my-chats', function () {
    if (auth('seller')->check()) {
        return redirect()->route('seller.inbox');
    }

    if (auth('web')->check()) {
        return redirect()->route('chat.chats');
    }

    return redirect('/login');
})->name('my-chats');