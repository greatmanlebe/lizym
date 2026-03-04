<?php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function startChat(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
        ]);

        $buyer = auth('web')->user();

        $conversation = Conversation::firstOrCreate([
            'buyer_id'  => $buyer->id,
            'seller_id' => $request->seller_id,
        ]);

        return redirect()->route('chat.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        if (!auth('web')->check() && !auth('seller')->check()) {
            return redirect('/login');
        }

        if (auth('web')->check() && $conversation->buyer_id !== auth('web')->id()) {
            abort(403);
        }

        if (auth('seller')->check() && $conversation->seller_id !== auth('seller')->id()) {
            abort(403);
        }

        $messages = $conversation->messages()->orderBy('created_at')->get();

        return inertia('chat/Conversation', [
            'conversation' => $conversation,
            'messages'     => $messages,
        ]);
    }

public function send(Request $request, Conversation $conversation)
{
    $request->validate([
        'message' => 'required|string',
    ]);

    // Ensure user is logged in
    if (!auth('web')->check() && !auth('seller')->check()) {
        return redirect('/login');
    }

    // Detect sender correctly
    if (auth('web')->check()) {
        $senderType = 'buyer';
        $senderId = auth('web')->id();
    } else {
        $senderType = 'seller';
        $senderId = auth('seller')->id();
    }

    Message::create([
        'conversation_id' => $conversation->id,
        'sender_id'       => $senderId,
        'sender_type'     => $senderType,
        'message'         => $request->message,
    ]);

    $conversation->touch();

    return back();
}

}