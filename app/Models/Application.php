<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    /**
     * Use the singular database table name `application`.
     */
    protected $table = 'application';
    
    public $timestamps = false;

    /**
     * Allow mass assignment for the fields that exist in the DB.
     */
    protected $fillable = [
        'jobseeker_id',
        'jobpost_id',
        'motivation',
        'date',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'jobseeker_id');
    }

    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class, 'jobpost_id');
    }
}