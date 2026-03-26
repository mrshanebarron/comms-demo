<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['name', 'type', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            'private' => 'lock-closed',
            'direct' => 'chat-bubble-left-right',
            default => 'hashtag',
        };
    }
}
