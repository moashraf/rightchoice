<?php

namespace App\Models\Chat;

use MongoDB\Laravel\Eloquent\Model;

class PostComment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'post_comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    // ── Relations ────────────────────────────────────────────────

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function getUser()
    {
        return \App\Models\User::find($this->user_id);
    }
}
