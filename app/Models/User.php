<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Import Eloquent relationship classes.
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\JobPost;
use App\Models\CV;
use App\Models\Skill;

class User extends Authenticatable {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Disable default created_at and updated_at timestamps for this model.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * Only these fields may be filled using methods like create() or update().
     * This protects against mass-assignment vulnerabilities.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'photo_path',
        'location'
    ];

    /**
     * The attributes that should be hidden when serializing the model
     * (e.g., to arrays or JSON).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to a specific type.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            // Ensures password is always hashed automatically when set.
            'password' => 'hashed',
        ];
    }

    /**
     * Get the jobposts owned by this user.
     *
     * Defines a one-to-many relationship:
     * a user can have multiple jobposts.
     */
    public function jobposts(): HasMany {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    public function getPhotoUrlAttribute() {
        return $this->photo_path ? Storage::url($this->photo_path) : null;
    }

    public function cv(): HasOne {
        return $this->hasOne(CV::class, 'jobseeker_id');
    }
    /**
     * Get the applications owned by this user.
     *
     * Defines a one-to-many relationship:
     * a user can have multiple applications.
     */
    public function applications(): HasMany {
        return $this->hasMany(Application::class, 'jobseeker_id', 'id');
    }


    public function skills() {
        return $this->belongsToMany(Skill::class, 'skill_user', 'user_id', 'skill_id');
    }

    public function isDeleted() {
        return preg_match('/^deleted_\d+@delete\.app$/', $this->email) &&
        preg_match('/^Anonym\d+$/', $this->name) &&
        preg_match('/^DELETED_USER_\d+$/', $this->password) &&
        $this->phone_number === '000000000' && 
        $this->location === null &&
        $this->photo_path === null;
    }
    
}

