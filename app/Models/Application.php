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

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jobPost', function ($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%')
                          ->orWhere('location', 'like', '%' . $search . '%')
                          ->orWhere('work_model', 'like', '%' . $search . '%')
                          ->orWhere('contract_type', 'like', '%' . $search . '%')
                          ->orWhere('salary', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jobPost.jobCategory', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('motivation', 'like', '%' . $search . '%')
                    ->orWhere('blocked', 'like', '%' . $search . '%');
    }
}