<?php

namespace App\Models\Chat;

use MongoDB\Laravel\Eloquent\Model;

class Conversation extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'conversations';

    protected $fillable = [
        'participants',
        'type',
        'last_message',
    ];

    protected $casts = [
        'participants' => 'array',
        'last_message' => 'array',
    ];

    // ── Relations ────────────────────────────────────────────────

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    // ── Scopes ───────────────────────────────────────────────────

    public function scopeForUser($query, int $userId)
    {
        return $query->where('participants', $userId);
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function getOtherParticipantId(int $currentUserId): ?int
    {
        $participants = $this->participants ?? [];
        foreach ($participants as $id) {
            if ((int) $id !== $currentUserId) {
                return (int) $id;
            }
        }
        return null;
    }

    public function getOtherUser(int $currentUserId)
    {
        $otherId = $this->getOtherParticipantId($currentUserId);
        return $otherId ? \App\Models\User::find($otherId) : null;
    }

    public function updateLastMessage(Message $message): void
    {
        $this->update([
            'last_message' => [
                'text' => mb_substr($message->body, 0, 100),
                'sender_id' => $message->sender_id,
                'sent_at' => $message->created_at->toISOString(),
            ],
        ]);
    }
}
