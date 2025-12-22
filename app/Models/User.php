<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Import Eloquent relationship classes.
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\JobPost;
use App\Models\CV;
use App\Models\Skill;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public $timestamps  = true;

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
        'location',
        'description'
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
    protected function casts(): array
    {
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
    public function jobposts(): HasMany
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    public function avatarUrl(): string
    {
        return $this->photoUrl() ?? asset('/images/profile-placeholder.png');
    }

    public function photoUrl() : ?string
    {
        return $this->photo_path ? Storage::url($this->photo_path) : null;
    }

    public function cv(): HasOne
    {
        return $this->hasOne(CV::class, 'jobseeker_id');
    }
    /**
     * Get the applications owned by this user.
     *
     * Defines a one-to-many relationship:
     * a user can have multiple applications.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'jobseeker_id', 'id');
    }


    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user', 'user_id', 'skill_id');
    }

    public function favouriteJobs()
    {
        return $this->belongsToMany(JobPost::class, 'favourite_job', 'jobseeker_id', 'jobpost_id');
    }

    public function isDeleted()
    {
        return preg_match('/^deleted_\d+@delete\.app$/', $this->email) &&
            preg_match('/^Anonym\d+$/', $this->name) &&
            preg_match('/^DELETED_USER_\d+$/', $this->password) &&
            $this->phone_number === '000000000' &&
            $this->location === null &&
            $this->photo_path === null;
    }

    public function notifications(): BelongsToMany
    {
        return $this->belongsToMany(
            Notification::class,
            'user_notification'
        )->withPivot('seen');
    }

    public function blockedRecord(): HasOne
    {
        return $this->hasOne(BlockedUser::class, 'id', 'blocked_id');
    }

    public function isBlocked(): bool
    {
        return !is_null($this->blocked_id);
    }

    public function blockReason(): ?string
    {
        return $this->blockedRecord?->reason;
    }

    public function blockedBy(): ?int
    {
        return $this->blockedRecord?->admin_id;
    }

    public function blockedAt(): ?string
    {
        return $this->blockedRecord?->blocked_at;
    }

    public function block($reason, $adminId): void
    {
        if ($this->role === 'Admin') {
            throw new \Exception('Cannot block admin users.');
        }

        if ($this->isBlocked()) {
            throw new \Exception('User is already blocked.');
        }

        if ($this->role === 'Employer') {
            JobPost::where('employer_id', $this->id)->update(['blocked' => true]);
        }
        if ($this->role === 'JobSeeker') {
            Application::where('jobseeker_id', $this->id)->update(['blocked' => true]);
        }

        $blockedUser = BlockedUser::create([
            'user_id' => $this->id,
            'admin_id' => $adminId,
            'reason' => $reason,
            'blocked_at' => now(),
        ]);

        $this->blocked_id = $blockedUser->id;
        $this->save();
    }

    public function unblock(): void
    {
        if (!$this->isBlocked()) {
            throw new \Exception('User is not blocked.');
        }

        if ($this->role === 'Employer') {
            JobPost::where('employer_id', $this->id)->update(['blocked' => false]);
        }
        if ($this->role === 'JobSeeker') {
            Application::where('jobseeker_id', $this->id)->update(['blocked' => false]);
        }

        $blockedUserId = $this->blocked_id;
        $this->blocked_id = null;
        $this->save();
        BlockedUser::destroy($blockedUserId);
    }

    public static function search($search)
    {
        $query = self::query();

        if (!$search) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('phone_number', 'like', '%' . $search . '%')
            ->orWhere('role', 'like', '%' . $search . '%');
    }
}
