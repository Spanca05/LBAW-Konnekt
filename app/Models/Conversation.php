<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model {
    protected $table = 'conversation';

    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'application_id'
    ];

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function messages(): HasMany {
        return $this->hasMany(Message::class, 'conversation_id');
    }
}
