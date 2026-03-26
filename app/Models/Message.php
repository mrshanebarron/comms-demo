<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['channel_id', 'user_id', 'body', 'is_pinned', 'original_created_at'];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'original_created_at' => 'datetime',
        ];
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
