<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Conversation;

class SellerInboxController extends Controller
{
    public function index()
    {
        $seller = auth('seller')->user();

        $conversations = Conversation::with(['buyer', 'messages' => function ($q) {
            $q->latest()->limit(1);
        }])
        ->where('seller_id', $seller->id)
        ->orderBy('updated_at', 'desc')
        ->get()
        ->map(function ($c) {
            $c->last_message = $c->messages->first();
            return $c;
        });


        return inertia('seller/Inbox', [
            'conversations' => $conversations
        ]);
    }
}