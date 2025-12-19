<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Import Eloquent relationship classes.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Notification extends Model
{
    public const CREATED_AT = 'date';
    public const UPDATED_AT = null;

    protected $table = 'notification';
    protected $fillable = [
        'title',
        'date',
        'type',
        'jobpost_id',
        'application_id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_notification'
        )->withPivot('seen');
    }


    public function jobPost(): BelongsTo {
        return $this->belongsTo(JobPost::class, 'jobpost_id');
    }

    
    public function application(): BelongsTo {
        return $this->belongsTo(Application::class);
    }


}
