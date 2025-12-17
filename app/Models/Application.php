<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    
    protected $table = 'application';
    
    public $timestamps = false;

    protected $fillable = [
        'jobseeker_id',
        'jobpost_id',
        'motivation',
        'date',
        'status',
        'blocked',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'jobseeker_id');
    }

    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class, 'jobpost_id');
    }

    public function isBlocked(): bool
    {
        return $this->blocked === true;
    }
}