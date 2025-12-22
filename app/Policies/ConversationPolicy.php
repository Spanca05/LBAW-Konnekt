<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy 
{
    public function view(User $user, Conversation $conversation): bool
    {
        return $this->canParticipate($user, $conversation);
    }

    public function send(User $user, Conversation $conversation): bool
    {
        return $this->canParticipate($user, $conversation);
    }

    private function canParticipate(User $user, Conversation $conversation): bool
    {
        $application = $conversation->application;
       
        if(!$application || !$application->jobPost) return false;

        $isParticipant = $user->id === $application->jobseeker_id || $user->id === $application->jobPost->employer_id;

        return $application->status === 'Accepted' && $isParticipant;
    }
}