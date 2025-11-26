<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
}