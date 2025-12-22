<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Conversation;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{conversation}', function (User $user, Conversation $conversation): bool {
    $application = $conversation->application;

    if (!$application) {
        return false;
    }

    $jobSeekerId = $application->jobseeker_id ?? null;
    $employerId = $application->jobPost?->employer_id ?? null;

    return $user->id === $jobSeekerId || $user->id === $employerId;
});