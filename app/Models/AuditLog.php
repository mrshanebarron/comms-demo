<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'admin_id', 'auditable_type', 'auditable_id',
        'original_timestamp', 'modified_timestamp', 'reason',
    ];

    protected function casts(): array
    {
        return [
            'original_timestamp' => 'datetime',
            'modified_timestamp' => 'datetime',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
