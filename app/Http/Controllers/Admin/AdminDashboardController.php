<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerDocument;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'totalSellers'        => Seller::count(),
                'pendingCerts'        => Seller::where('certification_status', 'pending')->count(),
                'verifiedSellers'     => Seller::where('certification_status', 'verified')->count(),
                'goldSellers'         => Seller::where('certification_status', 'gold')->count(),
                'platinumSellers'     => Seller::where('certification_status', 'platinum')->count(),
                'rejectedSellers'     => Seller::where('certification_status', 'rejected')->count(),
                'pendingDocuments'    => SellerDocument::where('status', 'pending')->count(),
            ]
        ]);
    }
}