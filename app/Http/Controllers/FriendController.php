<?php

namespace App\Http\Controllers;

use App\Services\Chat\FriendshipService;
use App\Services\Chat\BlockService;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    protected FriendshipService $friendshipService;
    protected BlockService $blockService;

    public function __construct(FriendshipService $friendshipService, BlockService $blockService)
    {
        $this->friendshipService = $friendshipService;
        $this->blockService = $blockService;
    }

    /**
     * Show friends page with tabs.
     */
    public function index()
    {
        $user = auth()->user();
        $friends = $this->friendshipService->getFriends($user->id);
        $pendingRequests = $this->friendshipService->getPendingRequests($user->id);
        $sentRequests = $this->friendshipService->getSentRequests($user->id);

        return view('friends.index', compact('friends', 'pendingRequests', 'sentRequests'));
    }

    /**
     * Send friend request.
     */
    public function sendRequest(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);
        $user = auth()->user();

        try {
            $this->friendshipService->sendRequest($user->id, (int) $request->user_id);
            return response()->json(['success' => true, 'message' => trans('langsite.friend_request_sent')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Accept friend request.
     */
    public function acceptRequest(Request $request, string $friendshipId)
    {
        $user = auth()->user();

        try {
            $this->friendshipService->acceptRequest($friendshipId, $user->id);
            return response()->json(['success' => true, 'message' => trans('langsite.friend_request_accepted')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Decline friend request.
     */
    public function declineRequest(Request $request, string $friendshipId)
    {
        $user = auth()->user();

        try {
            $this->friendshipService->declineRequest($friendshipId, $user->id);
            return response()->json(['success' => true, 'message' => trans('langsite.friend_request_declined')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Remove friend.
     */
    public function removeFriend(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);
        $user = auth()->user();

        $result = $this->friendshipService->removeFriend($user->id, (int) $request->user_id);

        return response()->json([
            'success' => $result,
            'message' => $result ? trans('langsite.friend_removed') : trans('langsite.error_occurred'),
        ]);
    }

    /**
     * Search users to add as friends.
     */
    public function searchUsers(Request $request)
    {
        $request->validate(['q' => 'required|string|min:2']);
        $user = auth()->user();

        $users = \App\Models\User::where('id', '!=', $user->id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%');
            })
            ->where('status', 1)
            ->limit(20)
            ->get(['id', 'name', 'email', 'profile_image']);

        $results = $users->map(function ($u) use ($user) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'profile_image' => $u->profile_image
                    ? url('/images/' . $u->profile_image)
                    : url('/images/default-avatar.png'),
                'is_friend' => $this->friendshipService->areFriends($user->id, $u->id),
                'is_blocked' => $this->blockService->isBlocked($user->id, $u->id),
            ];
        });

        return response()->json(['users' => $results]);
    }
}
