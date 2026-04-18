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
        ], [
            'user_id.required' => 'حقل معرف المستخدم مطلوب.',
            'user_id.integer'  => 'معرف المستخدم يجب أن يكون رقمًا صحيحًا.',
            'user_id.exists'   => 'المستخدم غير موجود في النظام.',
            'reason.string'    => 'سبب الحجب يجب أن يكون نصاً.',
            'reason.max'       => 'سبب الحجب يجب ألا يتجاوز 500 حرف.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
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
        ], [
            'user_id.required' => 'حقل معرف المستخدم مطلوب.',
            'user_id.integer'  => 'معرف المستخدم يجب أن يكون رقمًا صحيحًا.',
            'user_id.exists'   => 'المستخدم غير موجود في النظام.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $result = $this->blockService->unblockUser($request->user()->id, (int) $request->user_id);

        return $result
            ? $this->sendSuccess('User unblocked successfully')
            : $this->sendError('Failed to unblock user', 400);
    }
}

