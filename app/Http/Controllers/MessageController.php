<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MessageController extends Controller
{
    use AuthorizesRequests;

    public function store(Conversation $conversation, Request $request) 
    {
        $user = Auth::user();

        $this->authorize('send', $conversation);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'body' => $data['body'],
        ]);


        // Broadcast to other participants
        broadcast(new MessageSent($message))->toOthers();

        //Update updated_at
        $conversation->touch();

        return redirect()
            ->route('conversations.show', $conversation)
            ->with('success', 'Message sent.');
    }
}