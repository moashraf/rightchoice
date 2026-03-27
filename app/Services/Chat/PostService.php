<?php

namespace App\Services\Chat;

use App\Models\Chat\Post;
use App\Models\Chat\PostComment;
use App\Models\Chat\UserBlock;
use Illuminate\Support\Facades\File;

class PostService
{
    protected BlockService $blockService;

    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    public function createPost(int $userId, string $content, array $images = []): Post
    {
        $savedImages = [];

        foreach ($images as $image) {
            $filename = uniqid('post_') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $filename);
            $savedImages[] = $filename;
        }

        return Post::create([
            'user_id' => $userId,
            'content' => $content,
            'images' => $savedImages,
            'likes' => [],
            'likes_count' => 0,
            'comments_count' => 0,
            'is_active' => true,
        ]);
    }

    public function getFeed(int $userId, int $perPage = 20)
    {
        // Exclude posts from blocked users
        $blockedIds = UserBlock::where('blocker_id', $userId)->pluck('blocked_id')->toArray();
        $blockedByIds = UserBlock::where('blocked_id', $userId)->pluck('blocker_id')->toArray();
        $excludeIds = array_unique(array_merge($blockedIds, $blockedByIds));

        $query = Post::where('is_active', true);

        if (!empty($excludeIds)) {
            $query->whereNotIn('user_id', $excludeIds);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getUserPosts(int $userId, int $perPage = 20)
    {
        return Post::where('user_id', $userId)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function toggleLike(string $postId, int $userId): array
    {
        $post = Post::findOrFail($postId);
        $liked = $post->toggleLike($userId);

        return [
            'liked' => $liked,
            'likes_count' => $post->fresh()->likes_count,
        ];
    }

    public function addComment(string $postId, int $userId, string $content): PostComment
    {
        $post = Post::findOrFail($postId);

        if ($this->blockService->isBlocked($userId, $post->user_id)) {
            throw new \Exception('لا يمكنك التعليق على هذا المنشور');
        }

        $comment = PostComment::create([
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $content,
        ]);

        $post->incrementCommentsCount();

        return $comment;
    }

    public function deletePost(string $postId, int $userId): bool
    {
        $post = Post::findOrFail($postId);

        if ($post->user_id !== $userId) {
            return false;
        }

        // Delete post images
        foreach ($post->images ?? [] as $img) {
            $path = public_path('uploads/posts/' . $img);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        // Delete comments
        PostComment::where('post_id', (string) $post->_id)->delete();

        $post->delete();
        return true;
    }

    public function deleteComment(string $commentId, int $userId): bool
    {
        $comment = PostComment::findOrFail($commentId);
        $post = Post::find($comment->post_id);

        // Can delete own comment, or post owner can delete any comment
        if ($comment->user_id !== $userId && (!$post || $post->user_id !== $userId)) {
            return false;
        }

        $comment->delete();

        if ($post) {
            $post->decrementCommentsCount();
        }

        return true;
    }
}
