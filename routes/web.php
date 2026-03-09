<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Product;
use App\Models\Seller;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Seller\RegisterController as SellerRegister;
use App\Http\Controllers\Seller\LoginController as SellerLogin;
use App\Http\Controllers\Seller\SellerInboxController;

use App\Http\Controllers\ChatController;

Route::middleware([\App\Http\Middleware\SetLocale::class])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LANGUAGE SWITCHER
    |--------------------------------------------------------------------------
    */
    Route::get('/lang/{locale}', function ($locale) {
        $available = ['en', 'fr'];

        if (! in_array($locale, $available)) {
            $locale = 'en';
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return back();
    })->name('lang.switch');


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

    Route::get('/home', fn() => Inertia::render('Home'));


    /*
    |--------------------------------------------------------------------------
    | BUYER AUTH
    |--------------------------------------------------------------------------
    */
    Route::get('/register', [RegisterController::class, 'show']);
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);


    /*
    |--------------------------------------------------------------------------
    | BUYER PROTECTED ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:web')->group(function () {

        Route::get('/shop', function () {
            return Inertia::render('Shop', [
                'products' => Product::all(),
            ]);
        });

        // Buyer starts chat from checkout
// ✅ SAFE for InfinityFree hosting
Route::post('/checkout/message', [ChatController::class, 'startChat'])
    ->name('checkout.start-chat');  // Keep the NAME the same!

        // Buyer chat list
        Route::get('/chat/chats', function () {
            $buyer = auth('web')->user();

            $conversations = Conversation::with([
                'seller',
                'messages' => fn($q) => $q->latest()->limit(1)
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
                 'buyer' => $buyer,
            ]);
        })->name('chat.chats');
    });


    /*
    |--------------------------------------------------------------------------
    | SELLER AUTH + DASHBOARD
    |--------------------------------------------------------------------------
    */
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
            Route::get('/products/create', fn() => inertia('seller/Addproducts'));

            Route::post('/products', function (Request $request) {
                $request->validate([
                    'name' => 'required',
                    'price' => 'required|numeric',
                    'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                    'category' => 'required',
                    'description' => 'required',
                ]);

                // Save image to public/img
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('img'), $imageName);

                Product::create([
                    'seller_id' => auth('seller')->id(),
                    'name' => $request->name,
                    'price' => $request->price,
                    'image' => $imageName, // store only the filename
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

            // Seller inbox
            Route::get('/inbox', [SellerInboxController::class, 'index'])
                ->name('seller.inbox');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | EACH SELLER PAGE
    |--------------------------------------------------------------------------
    */
    Route::get('/shop/{seller}', function (Seller $seller) {

        return inertia('shop/Sellershop', [
            'seller' => $seller,
            'products' => Product::where('seller_id', $seller->id)->get(),
        ]);
    });


    /*
    |--------------------------------------------------------------------------
    | SHARED CHAT ROUTES
    |--------------------------------------------------------------------------
    */
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])
        ->name('chat.show');

    Route::post('/chat/{conversation}/message', [ChatController::class, 'send'])
        ->name('chat.send');


    /*
    |--------------------------------------------------------------------------
    | UNIVERSAL CHAT BUTTON
    |--------------------------------------------------------------------------
    */
    Route::get('/my-chats', function () {

        if (auth('seller')->check()) {
            return redirect()->route('seller.inbox');
        }

        if (auth('web')->check()) {
            return redirect()->route('chat.chats');
        }

        return redirect()->route('login');
    })->name('my-chats');

});