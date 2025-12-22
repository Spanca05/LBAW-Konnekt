<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Conversation extends Model {
    protected $table = 'conversation';

    public $timestamps = true;

    protected $fillable = [
        'application_id'
    ];

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function messages(): HasMany {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function latestMessagePreview(): ?string
    {
        if(!$this->latestMessage || trim($this->latestMessage->body) === '') {
            return null;
        }

        return Str::limit($this->latestMessage->body, 60);
    }

    public function otherUserFor(User $user): User
    {
        return $user->id === $this->application->jobPost->employer_id
            ? $this->application->user  // jobseeker
            : $this->application->jobPost->employer;
    }
    
    public function displayNameForOtherUser(User $user): string
    {
        return $this->otherUserFor($user)->name;
    }

    public function displayConversationName(User $user): string
    {
        $jobPost = $this->application->jobPost;

        return $jobPost->title . ' - ' . $this->displayNameForOtherUser($user);
    }
}
