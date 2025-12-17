<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Import Eloquent relationship classes.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * Only these fields may be filled using methods like create() or update().
     * This protects against mass-assignment vulnerabilities.
     *
     * @var list<string>
     */
    protected $table = 'jobpost';
    protected $fillable = [
        'title',
        'employer_id',
        'salary',
        'work_model',
        'contract_type',
        'description',
        'category_id',
        'location',
        'deadline',
        'blocked'
    ];

    protected $casts = [
        'deadline' => 'datetime'
    ];

    public function employer(): BelongsTo{
        return $this->belongsTo(User::class, 'employer_id');
    }
    

    public function jobCategory(): BelongsTo{
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function notifications(): HasMany{
        return $this->hasMany(Notification::class, 'jobpost_id');
    }

    public function jobUser(): BelongsTo{
        return $this->belongsTo(User::class, 'employer_id', 'id');
    }

    public function applications(): HasMany {
        return $this->hasMany(Application::class, 'jobpost_id', 'id');
    }

    public function isOwnerDeleted(): bool {
        return $this->employer && $this->employer->isDeleted();
    }

    public function favouritedBy() {
        return $this->belongsToMany(User::class, 'favourite_job', 'jobpost_id', 'jobseeker_id');
    }

    public function isBlocked(): bool
    {
        return $this->blocked === true;
    }
}
