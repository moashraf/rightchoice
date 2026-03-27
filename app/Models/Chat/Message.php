<?php

namespace App\Models\Chat;

use MongoDB\Laravel\Eloquent\Model;

class Message extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'messages';

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'type',
        'body',
        'read_by',
        'is_deleted',
    ];

    protected $casts = [
        'read_by' => 'array',
        'is_deleted' => 'boolean',
        'sender_id' => 'integer',
    ];

    protected $attributes = [
        'type' => 'text',
        'is_deleted' => false,
        'read_by' => '[]',
    ];

    // ── Relations ────────────────────────────────────────────────

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function getSender()
    {
        return \App\Models\User::find($this->sender_id);
    }

    public function markAsRead(int $userId): void
    {
        $readBy = $this->read_by ?? [];

        foreach ($readBy as $entry) {
            if ((int) ($entry['user_id'] ?? 0) === $userId) {
                return; // already read
            }
        }

        $readBy[] = [
            'user_id' => $userId,
            'read_at' => now()->toISOString(),
        ];

        $this->update(['read_by' => $readBy]);
    }

    public function isReadBy(int $userId): bool
    {
        foreach ($this->read_by ?? [] as $entry) {
            if ((int) ($entry['user_id'] ?? 0) === $userId) {
                return true;
            }
        }
        return false;
    }
}
