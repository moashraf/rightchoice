<?php

namespace App\Models\Chat;

use MongoDB\Laravel\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    protected $fillable = [
        'user_id',
        'content',
        'images',
        'likes',
        'likes_count',
        'comments_count',
        'is_active',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'images' => 'array',
        'likes' => 'array',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'images' => '[]',
        'likes' => '[]',
        'likes_count' => 0,
        'comments_count' => 0,
        'is_active' => true,
    ];

    // ── Relations ────────────────────────────────────────────────

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function getUser()
    {
        return \App\Models\User::find($this->user_id);
    }

    public function isLikedBy(int $userId): bool
    {
        return in_array($userId, $this->likes ?? []);
    }

    public function toggleLike(int $userId): bool
    {
        $likes = $this->likes ?? [];

        if (in_array($userId, $likes)) {
            $likes = array_values(array_diff($likes, [$userId]));
            $liked = false;
        } else {
            $likes[] = $userId;
            $liked = true;
        }

        $this->update([
            'likes' => $likes,
            'likes_count' => count($likes),
        ]);

        return $liked;
    }

    public function incrementCommentsCount(): void
    {
        $this->increment('comments_count');
    }

    public function decrementCommentsCount(): void
    {
        if ($this->comments_count > 0) {
            $this->decrement('comments_count');
        }
    }
}
