<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Import Eloquent relationship classes.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    // Disable default created_at and updated_at timestamps for this model.
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * Only these fields may be filled using methods like create() or update().
     * This protects against mass-assignment vulnerabilities.
     *
     * @var list<string>
     */
    protected $table = 'location';
    protected $fillable = [
        'country',
        'id',
        'province',
        'city',
        'address',
        'postal_code'
    ];
    

    public function jobPosts(): HasMany{
        return $this->hasMany(JobPost::class, 'location_id');
    }

}
