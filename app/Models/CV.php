<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CV extends Model
{
    protected $table = 'cv';
    public $timestamps = true;

    protected $fillable = [
        'jobseeker_id',
        'description',
        'file_path',
        'mime_type',
        'uploaded_at',
        'updated_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function jobseeker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'jobseeker_id');
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }
}