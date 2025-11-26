<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Import Eloquent relationship classes.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    // Disable default created_at and updated_at timestamps for this model.
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
        'description',
        'category_id',
        'location_id'
    ];


    public function employer(): BelongsTo{
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function jobLocation(): BelongsTo{
        return $this->belongsTo(Location::class, 'location_id', 'id');
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
}
