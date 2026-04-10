<?php

namespace App\Http\Controllers\API;

use App\Services\Chat\FriendshipService;
use App\Services\Chat\BlockService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

/**
 * Friends API Controller.
 */
class FriendAPIController extends AppBaseController
{
    protected FriendshipService $friendshipService;
    protected BlockService $blockService;

    public function __construct(FriendshipService $friendshipService, BlockService $blockService)
    {
        $this->friendshipService = $friendshipService;
        $this->blockService = $blockService;
    }

    /**
     * GET /api/friends
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->sendResponse([
            'friends'          => $this->friendshipService->getFriends($user->id),
            'pending_requests' => $this->friendshipService->getPendingRequests($user->id),
            'sent_requests'    => $this->friendshipService->getSentRequests($user->id),
        ], 'Friends retrieved successfully');
    }

    /**
     * POST /api/friends/request
     */
    public function sendRequest(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        try {
            $this->friendshipService->sendRequest($request->user()->id, (int) $request->user_id);
            return $this->sendSuccess('Friend request sent');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * POST /api/friends/{friendshipId}/accept
     */
    public function acceptRequest(Request $request, string $friendshipId): JsonResponse
    {
        try {
            $this->friendshipService->acceptRequest($friendshipId, $request->user()->id);
            return $this->sendSuccess('Friend request accepted');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * POST /api/friends/{friendshipId}/decline
     */
    public function declineRequest(Request $request, string $friendshipId): JsonResponse
    {
        try {
            $this->friendshipService->declineRequest($friendshipId, $request->user()->id);
            return $this->sendSuccess('Friend request declined');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * POST /api/friends/remove
     */
    public function removeFriend(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        $result = $this->friendshipService->removeFriend($request->user()->id, (int) $request->user_id);

        return $result
            ? $this->sendSuccess('Friend removed')
            : $this->sendError('Failed to remove friend', 400);
    }

    /**
     * GET /api/friends/search?q=xxx
     */
    public function searchUsers(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'q' => 'required|string|min:2',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        $user = $request->user();

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
                'id'            => $u->id,
                'name'          => $u->name,
                'profile_image' => $u->profile_image_url,
                'is_friend'     => $this->friendshipService->areFriends($user->id, $u->id),
                'is_blocked'    => $this->blockService->isBlocked($user->id, $u->id),
            ];
        });

        return $this->sendResponse(['users' => $results], 'Users found');
    }
}

