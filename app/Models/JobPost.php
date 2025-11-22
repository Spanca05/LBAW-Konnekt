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
    

}
