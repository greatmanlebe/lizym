<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/home', function () {
    return Inertia\Inertia::render('Home');
});




// db
use App\Models\Product;
use Inertia\Inertia;

Route::get('/shop', function () {
    return Inertia::render('Shop', [
        'products' => Product::all(),
    ]);
});

require __DIR__.'/settings.php';
