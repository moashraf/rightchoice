<?php

namespace App\Http\Controllers\API;

use App\Services\Chat\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

/**
 * Community Posts API Controller.
 */
class PostAPIController extends AppBaseController
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * GET /api/community/posts
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $posts = $this->postService->getFeed($user->id);

        $data = $posts->getCollection()->map(function ($post) use ($user) {
            $author = $post->getUser();
            return [
                'id'           => (string) $post->_id,
                'content'      => $post->content,
                'images'       => $post->images ?? [],
                'user_id'      => $post->user_id,
                'user_name'    => $author ? $author->name : 'Deleted User',
                'user_image'   => $author ? $author->profile_image_url : null,
                'likes_count'  => $post->likes_count ?? 0,
                'comments_count' => $post->comments_count ?? 0,
                'is_liked'     => $post->isLikedBy($user->id),
                'is_mine'      => $post->user_id === $user->id,
                'created_at'   => $post->created_at->toDateTimeString(),
            ];
        });

        return $this->sendResponse([
            'posts'      => $data,
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page'    => $posts->lastPage(),
                'total'        => $posts->total(),
            ],
        ], 'Posts retrieved successfully');
    }

    /**
     * POST /api/community/posts
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:5000',
            'images'  => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $images = $request->hasFile('images') ? $request->file('images') : [];

        $post = $this->postService->createPost($user->id, $request->content, $images);

        return $this->sendSuccess('Post created successfully');
    }

    /**
     * POST /api/community/posts/{postId}/like
     */
    public function toggleLike(Request $request, string $postId): JsonResponse
    {
        $result = $this->postService->toggleLike($postId, $request->user()->id);

        return $this->sendResponse([
            'liked'       => $result['liked'],
            'likes_count' => $result['likes_count'],
        ], 'Like toggled');
    }

    /**
     * POST /api/community/posts/{postId}/comment
     */
    public function addComment(Request $request, string $postId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        try {
            $user = $request->user();
            $comment = $this->postService->addComment($postId, $user->id, $request->content);

            return $this->sendResponse([
                'id'         => (string) $comment->_id,
                'content'    => e($comment->content),
                'user_name'  => $user->name,
                'user_image' => $user->profile_image_url,
                'created_at' => $comment->created_at->toDateTimeString(),
            ], 'Comment added');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * GET /api/community/posts/{postId}/comments
     */
    public function getComments(string $postId): JsonResponse
    {
        $post = \App\Models\Chat\Post::findOrFail($postId);
        $comments = $post->comments()->orderBy('created_at', 'asc')->get();

        $data = $comments->map(function ($comment) {
            $user = $comment->getUser();
            return [
                'id'         => (string) $comment->_id,
                'content'    => e($comment->content),
                'user_name'  => $user ? $user->name : 'Deleted User',
                'user_image' => $user ? $user->profile_image_url : null,
                'created_at' => $comment->created_at->toDateTimeString(),
                'is_mine'    => $comment->user_id === auth()->id(),
            ];
        });

        return $this->sendResponse(['comments' => $data], 'Comments retrieved');
    }

    /**
     * DELETE /api/community/posts/{postId}
     */
    public function destroy(Request $request, string $postId): JsonResponse
    {
        $result = $this->postService->deletePost($postId, $request->user()->id);

        return $result
            ? $this->sendSuccess('Post deleted')
            : $this->sendError('Failed to delete post', 400);
    }

    /**
     * DELETE /api/community/comments/{commentId}
     */
    public function deleteComment(Request $request, string $commentId): JsonResponse
    {
        $result = $this->postService->deleteComment($commentId, $request->user()->id);

        return $result
            ? $this->sendSuccess('Comment deleted')
            : $this->sendError('Failed to delete comment', 400);
    }
}

