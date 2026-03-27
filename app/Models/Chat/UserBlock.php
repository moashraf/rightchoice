<?php

namespace App\Models\Chat;

use MongoDB\Laravel\Eloquent\Model;

class UserBlock extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'user_blocks';

    const UPDATED_AT = null;

    protected $fillable = [
        'blocker_id',
        'blocked_id',
        'reason',
    ];

    protected $casts = [
        'blocker_id' => 'integer',
        'blocked_id' => 'integer',
    ];

    // ── Helpers ──────────────────────────────────────────────────

    public function getBlocker()
    {
        return \App\Models\User::find($this->blocker_id);
    }

    public function getBlockedUser()
    {
        return \App\Models\User::find($this->blocked_id);
    }
}
