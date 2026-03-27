<?php

namespace App\Services\Chat;

use App\Models\Chat\Friendship;
use Illuminate\Support\Collection;

class FriendshipService
{
    protected BlockService $blockService;

    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    public function sendRequest(int $senderId, int $receiverId): Friendship
    {
        if ($senderId === $receiverId) {
            throw new \Exception('لا يمكنك إرسال طلب صداقة لنفسك');
        }

        if ($this->blockService->isBlocked($senderId, $receiverId)) {
            throw new \Exception('لا يمكنك إرسال طلب صداقة لهذا المستخدم');
        }

        $existing = Friendship::where(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->first();

        if ($existing) {
            if ($existing->status === 'accepted') {
                throw new \Exception('أنتما أصدقاء بالفعل');
            }
            if ($existing->status === 'pending') {
                throw new \Exception('يوجد طلب صداقة معلق بالفعل');
            }
            if ($existing->status === 'declined') {
                $existing->update(['sender_id' => $senderId, 'receiver_id' => $receiverId, 'status' => 'pending']);
                return $existing;
            }
        }

        return Friendship::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);
    }

    public function acceptRequest(string $friendshipId, int $userId): Friendship
    {
        $friendship = Friendship::findOrFail($friendshipId);

        if ($friendship->receiver_id !== $userId) {
            throw new \Exception('لا يمكنك قبول هذا الطلب');
        }

        if ($friendship->status !== 'pending') {
            throw new \Exception('هذا الطلب لم يعد معلقاً');
        }

        $friendship->update(['status' => 'accepted']);
        return $friendship;
    }

    public function declineRequest(string $friendshipId, int $userId): bool
    {
        $friendship = Friendship::findOrFail($friendshipId);

        if ($friendship->receiver_id !== $userId) {
            throw new \Exception('لا يمكنك رفض هذا الطلب');
        }

        $friendship->update(['status' => 'declined']);
        return true;
    }

    public function removeFriend(int $userId, int $friendId): bool
    {
        $friendship = Friendship::where(function ($q) use ($userId, $friendId) {
            $q->where('sender_id', $userId)->where('receiver_id', $friendId);
        })->orWhere(function ($q) use ($userId, $friendId) {
            $q->where('sender_id', $friendId)->where('receiver_id', $userId);
        })->where('status', 'accepted')->first();

        if (!$friendship) {
            return false;
        }

        $friendship->delete();
        return true;
    }

    public function getFriends(int $userId): Collection
    {
        $friendships = Friendship::forUser($userId)->accepted()->get();

        $friendIds = $friendships->map(fn($f) => $f->getOtherUserId($userId))->unique();

        return \App\Models\User::whereIn('id', $friendIds)->get();
    }

    public function getPendingRequests(int $userId): Collection
    {
        return Friendship::where('receiver_id', $userId)->pending()->get();
    }

    public function getSentRequests(int $userId): Collection
    {
        return Friendship::where('sender_id', $userId)->pending()->get();
    }

    public function areFriends(int $userId1, int $userId2): bool
    {
        return Friendship::where(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId1)->where('receiver_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId2)->where('receiver_id', $userId1);
        })->where('status', 'accepted')->exists();
    }
}
