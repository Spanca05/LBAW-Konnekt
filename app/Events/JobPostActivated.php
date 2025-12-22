<?php

namespace App\Events;

use App\Models\JobPost;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobPostActivated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jobPost;
    public $message;

    public function __construct(JobPost $jobPost)
    {
        $this->jobPost = $jobPost;
        $this->message = "JobPost '{$jobPost->title}' has been created!";
    }


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->jobPost->employer_id),
        ];
    }

    public function broadcastAs()
    {
        return 'jobpost.active';
    }
}