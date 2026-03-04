<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Conversation;

class SellerInboxController extends Controller
{
    public function index()
    {
        $seller = auth('seller')->user();

        $conversations = Conversation::with('buyer')
            ->where('seller_id', $seller->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return inertia('seller/Inbox', [
            'conversations' => $conversations
        ]);
    }
}