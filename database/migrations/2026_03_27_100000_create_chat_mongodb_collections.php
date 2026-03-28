<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mongodb';

    public function up(): void
    {
        // conversations
        Schema::connection('mongodb')->table('conversations', function ($collection) {
            $collection->index('participants');
            $collection->index('updated_at');
        });

        // messages
        Schema::connection('mongodb')->table('messages', function ($collection) {
            $collection->index(['conversation_id', 'created_at']);
            $collection->index('sender_id');
        });

        // friendships
        Schema::connection('mongodb')->table('friendships', function ($collection) {
            $collection->index(['sender_id', 'status']);
            $collection->index(['receiver_id', 'status']);
            $collection->unique(['sender_id', 'receiver_id']);
        });

        // user_blocks
        Schema::connection('mongodb')->table('user_blocks', function ($collection) {
            $collection->index('blocker_id');
            $collection->index('blocked_id');
            $collection->unique(['blocker_id', 'blocked_id']);
        });

        // reports
        Schema::connection('mongodb')->table('reports', function ($collection) {
            $collection->index('reporter_id');
            $collection->index('reported_id');
            $collection->index('status');
        });

        // posts
        Schema::connection('mongodb')->table('posts', function ($collection) {
            $collection->index(['user_id', 'created_at']);
            $collection->index('created_at');
        });

        // post_comments
        Schema::connection('mongodb')->table('post_comments', function ($collection) {
            $collection->index(['post_id', 'created_at']);
            $collection->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('conversations');
        Schema::connection('mongodb')->dropIfExists('messages');
        Schema::connection('mongodb')->dropIfExists('friendships');
        Schema::connection('mongodb')->dropIfExists('user_blocks');
        Schema::connection('mongodb')->dropIfExists('reports');
        Schema::connection('mongodb')->dropIfExists('posts');
        Schema::connection('mongodb')->dropIfExists('post_comments');
    }
};
