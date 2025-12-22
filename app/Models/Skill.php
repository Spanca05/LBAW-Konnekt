<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\User;
use App\Models\JobPost;
use App\Models\Category;

class Skill extends Model
{
    protected $table = 'skill';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'description',
        'name'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'skill_user', 'skill_id', 'user_id');
    }

    public function jobposts(): BelongsToMany
    {
        return $this->belongsToMany(JobPost::class, 'skill_jobpost', 'skill_id', 'jobpost_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'skill_category', 'skill_id', 'category_id');
    }
}