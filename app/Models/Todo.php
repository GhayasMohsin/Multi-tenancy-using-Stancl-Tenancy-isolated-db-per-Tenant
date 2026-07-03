<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    protected $fillable = [
        'user_id', 'title', 'notes', 'due_date',
        'priority', 'status', 'completed_at',
    ];

    protected $casts = [
        'due_date'     => 'datetime',
        'completed_at' => 'datetime',
    ];

    public const PRIORITIES = ['low', 'medium', 'high'];
    public const STATUSES   = ['pending', 'in_progress', 'done'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markDone(): void
    {
        $this->update(['status' => 'done', 'completed_at' => now()]);
    }

    public function markPending(): void
    {
        $this->update(['status' => 'pending', 'completed_at' => null]);
    }
}
