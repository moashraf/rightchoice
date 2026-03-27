<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\CreatePostRequest;
use App\Http\Requests\Chat\AddCommentRequest;
use App\Services\Chat\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Show community feed.
     */
    public function index()
    {
        $user = auth()->user();
        $posts = $this->postService->getFeed($user->id);

        // Enrich posts with user info
        $posts->getCollection()->each(function ($post) use ($user) {
            $post->author = $post->getUser();
            $post->is_liked = $post->isLikedBy($user->id);
            $post->is_mine = $post->user_id === $user->id;
        });

        return view('community.index', compact('posts'));
    }

    /**
     * Create a new post.
     */
    public function store(CreatePostRequest $request)
    {
        $user = auth()->user();
        $images = $request->hasFile('images') ? $request->file('images') : [];

        $post = $this->postService->createPost($user->id, $request->content, $images);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => trans('langsite.post_created'),
            ]);
        }

        return redirect()->back()->with('success', trans('langsite.post_created'));
    }

    /**
     * Toggle like on a post (AJAX).
     */
    public function toggleLike(Request $request, string $postId)
    {
        $user = auth()->user();
        $result = $this->postService->toggleLike($postId, $user->id);

        return response()->json([
            'success' => true,
            'liked' => $result['liked'],
            'likes_count' => $result['likes_count'],
        ]);
    }

    /**
     * Add comment to a post (AJAX).
     */
    public function addComment(AddCommentRequest $request, string $postId)
    {
        $user = auth()->user();

        try {
            $comment = $this->postService->addComment($postId, $user->id, $request->content);

            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => (string) $comment->_id,
                    'content' => e($comment->content),
                    'user_name' => $user->name,
                    'user_image' => $user->profile_image
                        ? url('/images/' . $user->profile_image)
                        : url('/images/default-avatar.png'),
                    'created_at' => $comment->created_at->diffForHumans(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Get comments for a post (AJAX).
     */
    public function getComments(string $postId)
    {
        $post = \App\Models\Chat\Post::findOrFail($postId);
        $comments = $post->comments()->orderBy('created_at', 'asc')->get();

        $data = $comments->map(function ($comment) {
            $user = $comment->getUser();
            return [
                'id' => (string) $comment->_id,
                'content' => e($comment->content),
                'user_name' => $user ? $user->name : trans('langsite.deleted_user'),
                'user_image' => $user && $user->profile_image
                    ? url('/images/' . $user->profile_image)
                    : url('/images/default-avatar.png'),
                'created_at' => $comment->created_at->diffForHumans(),
                'is_mine' => $comment->user_id === auth()->id(),
            ];
        });

        return response()->json(['success' => true, 'comments' => $data]);
    }

    /**
     * Delete a post.
     */
    public function destroy(string $postId)
    {
        $user = auth()->user();
        $result = $this->postService->deletePost($postId, $user->id);

        if (request()->ajax()) {
            return response()->json(['success' => $result]);
        }

        return redirect()->back()->with($result ? 'success' : 'error',
            $result ? trans('langsite.post_deleted') : trans('langsite.error_occurred'));
    }

    /**
     * Delete a comment.
     */
    public function deleteComment(string $commentId)
    {
        $user = auth()->user();
        $result = $this->postService->deleteComment($commentId, $user->id);

        return response()->json(['success' => $result]);
    }
}
