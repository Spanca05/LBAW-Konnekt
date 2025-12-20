<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ConversationController extends Controller {
    use AuthorizesRequests;

    public function index() 
    {
        $user = Auth::user();

        $conversations = Conversation::query()
            ->whereHas('application', function ($q) use ($user) {
                $q->where('jobseeker_id', $user->id)
                ->orWhereHas('jobPost', function ($q2) use ($user) {
                    $q2->where('employer_id', $user->id);
                });
            })
            ->with([
                'application.jobPost',
                'application.jobSeeker',
                'application.jobPost.employer',
                'latestMessage.sender'
            ])
            ->paginate(20);

        return view('conversations.index', ['conversations' => $conversations]);
    }

    public function show(Conversation $conversation) {
        $this->authorize('view', $conversation);

        $conversation->load([
            'application.jobPost',
            'application.user',
            'application.jobPost.employer'
        ]);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->paginate(20);

        return view('conversations.show', [
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    public function getOrCreate(Application $application) {
        $this->authorize('openConversation', $application);

        $conversation = Conversation::firstOrCreate(['application_id' => $application->id]);

        return redirect()->route('conversations.show', $conversation)->with('success', 'Conversation started.');
    }
}
