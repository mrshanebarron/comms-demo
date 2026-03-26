<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'reference', 'user_id', 'assigned_to', 'subject',
        'description', 'priority', 'category', 'status',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'open' => 'sky',
            'in_progress' => 'amber',
            'waiting' => 'purple',
            'resolved' => 'green',
            'closed' => 'gray',
            default => 'gray',
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'gray',
            'medium' => 'sky',
            'high' => 'amber',
            'urgent' => 'red',
            default => 'gray',
        };
    }
}
