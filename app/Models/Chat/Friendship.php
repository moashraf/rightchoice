<?php

namespace App\Models\Chat;

use MongoDB\Laravel\Eloquent\Model;

class Friendship extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'friendships';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];

    protected $casts = [
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
    ];

    // ── Scopes ───────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->orWhere('receiver_id', $userId);
        });
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function getSender()
    {
        return \App\Models\User::find($this->sender_id);
    }

    public function getReceiver()
    {
        return \App\Models\User::find($this->receiver_id);
    }

    public function getOtherUserId(int $currentUserId): int
    {
        return $this->sender_id === $currentUserId
            ? $this->receiver_id
            : $this->sender_id;
    }
}
