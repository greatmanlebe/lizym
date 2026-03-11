<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminSellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::withCount('products')->get();

        return Inertia::render('admin/Sellers', [
            'sellers' => $sellers
        ]);
    }

public function show(Seller $seller)
{
    return Inertia::render('admin/SellerShow', [
        'seller'    => $seller,
        'documents' => $seller->documents()->get()
    ]);
}

    public function approve(Seller $seller)
    {
        $seller->update([
            'certification_status' => 'verified'
        ]);

        return back();
    }

    public function reject(Seller $seller)
    {
        $seller->update([
            'certification_status' => 'rejected'
        ]);

        return back();
    }

    public function setLevel(Request $request, Seller $seller)
    {
        $request->validate([
            'level' => 'required|in:verified,gold,platinum'
        ]);

        $seller->update([
            'certification_status' => $request->level
        ]);

        return back();
    }
}