<?php

namespace App\Http\Controllers\API;

use App\Services\Chat\BlockService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

/**
 * Block/Unblock API Controller.
 */
class BlockAPIController extends AppBaseController
{
    protected BlockService $blockService;

    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    /**
     * GET /api/blocked
     */
    public function index(Request $request): JsonResponse
    {
        $blockedUsers = $this->blockService->getBlockedUsers($request->user()->id);

        return $this->sendResponse(['blocked_users' => $blockedUsers], 'Blocked users retrieved');
    }

    /**
     * POST /api/block
     */
    public function block(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'reason'  => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        try {
            $this->blockService->blockUser($request->user()->id, (int) $request->user_id, $request->reason);
            return $this->sendSuccess('User blocked successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * POST /api/unblock
     */
    public function unblock(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        $result = $this->blockService->unblockUser($request->user()->id, (int) $request->user_id);

        return $result
            ? $this->sendSuccess('User unblocked successfully')
            : $this->sendError('Failed to unblock user', 400);
    }
}

