<?php

namespace App\Http\Controllers;

use App\Services\Chat\BlockService;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    protected BlockService $blockService;

    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    /**
     * Show blocked users page.
     */
    public function index()
    {
        $user = auth()->user();
        $blockedUsers = $this->blockService->getBlockedUsers($user->id);

        return view('blocked.index', compact('blockedUsers'));
    }

    /**
     * Block a user.
     */
    public function block(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'reason' => 'nullable|string|max:500',
        ]);
        $user = auth()->user();

        try {
            $this->blockService->blockUser($user->id, (int) $request->user_id, $request->reason);
            return response()->json(['success' => true, 'message' => trans('langsite.user_blocked')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Unblock a user.
     */
    public function unblock(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);
        $user = auth()->user();

        $result = $this->blockService->unblockUser($user->id, (int) $request->user_id);

        return response()->json([
            'success' => $result,
            'message' => $result ? trans('langsite.user_unblocked') : trans('langsite.error_occurred'),
        ]);
    }
}
