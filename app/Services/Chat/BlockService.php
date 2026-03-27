<?php

namespace App\Services\Chat;

use App\Models\Chat\UserBlock;
use Illuminate\Support\Collection;

class BlockService
{
    public function blockUser(int $blockerId, int $blockedId, ?string $reason = null): UserBlock
    {
        if ($blockerId === $blockedId) {
            throw new \Exception('لا يمكنك حظر نفسك');
        }

        $existing = UserBlock::where('blocker_id', $blockerId)
            ->where('blocked_id', $blockedId)
            ->first();

        if ($existing) {
            throw new \Exception('هذا المستخدم محظور بالفعل');
        }

        // Remove any friendship between them
        \App\Models\Chat\Friendship::where(function ($q) use ($blockerId, $blockedId) {
            $q->where('sender_id', $blockerId)->where('receiver_id', $blockedId);
        })->orWhere(function ($q) use ($blockerId, $blockedId) {
            $q->where('sender_id', $blockedId)->where('receiver_id', $blockerId);
        })->delete();

        return UserBlock::create([
            'blocker_id' => $blockerId,
            'blocked_id' => $blockedId,
            'reason' => $reason,
        ]);
    }

    public function unblockUser(int $blockerId, int $blockedId): bool
    {
        $block = UserBlock::where('blocker_id', $blockerId)
            ->where('blocked_id', $blockedId)
            ->first();

        if (!$block) {
            return false;
        }

        $block->delete();
        return true;
    }

    /**
     * Check if either user has blocked the other.
     */
    public function isBlocked(int $userId, int $otherUserId): bool
    {
        return UserBlock::where(function ($q) use ($userId, $otherUserId) {
            $q->where('blocker_id', $userId)->where('blocked_id', $otherUserId);
        })->orWhere(function ($q) use ($userId, $otherUserId) {
            $q->where('blocker_id', $otherUserId)->where('blocked_id', $userId);
        })->exists();
    }

    public function getBlockedUsers(int $userId): Collection
    {
        $blocks = UserBlock::where('blocker_id', $userId)->get();
        $blockedIds = $blocks->pluck('blocked_id');

        return \App\Models\User::whereIn('id', $blockedIds)->get();
    }
}
