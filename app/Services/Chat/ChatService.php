<?php

namespace App\Services\Chat;

use App\Models\Chat\Conversation;
use App\Models\Chat\Message;

class ChatService
{
    protected BlockService $blockService;

    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    public function getOrCreateConversation(int $userId1, int $userId2): Conversation
    {
        $conversation = Conversation::where('participants', 'all', [$userId1, $userId2])
            ->where('type', 'private')
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'participants' => [$userId1, $userId2],
                'type' => 'private',
                'last_message' => null,
            ]);
        }

        return $conversation;
    }

    public function sendMessage(string $conversationId, int $senderId, string $body, string $type = 'text'): Message
    {
        $conversation = Conversation::findOrFail($conversationId);

        $otherUserId = $conversation->getOtherParticipantId($senderId);
        if ($otherUserId && $this->blockService->isBlocked($senderId, $otherUserId)) {
            throw new \Exception('لا يمكنك إرسال رسالة لهذا المستخدم');
        }

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $senderId,
            'type' => $type,
            'body' => $body,
            'read_by' => [['user_id' => $senderId, 'read_at' => now()->toISOString()]],
            'is_deleted' => false,
        ]);

        $conversation->updateLastMessage($message);
        $conversation->touch();

        return $message;
    }

    public function getUserConversations(int $userId, int $perPage = 20)
    {
        return Conversation::forUser($userId)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }

    public function getMessages(string $conversationId, int $userId, int $perPage = 50)
    {
        $conversation = Conversation::findOrFail($conversationId);

        if (!in_array($userId, $conversation->participants ?? [])) {
            throw new \Exception('ليس لديك صلاحية لعرض هذه المحادثة');
        }

        return Message::where('conversation_id', $conversationId)
            ->where('is_deleted', false)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function markMessagesAsRead(string $conversationId, int $userId): void
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $userId)
            ->where('is_deleted', false)
            ->get();

        foreach ($messages as $message) {
            $message->markAsRead($userId);
        }
    }

    public function deleteMessage(string $messageId, int $userId): bool
    {
        $message = Message::findOrFail($messageId);

        if ($message->sender_id !== $userId) {
            return false;
        }

        $message->update(['is_deleted' => true]);
        return true;
    }

    public function getUnreadCount(int $userId): int
    {
        $conversations = Conversation::forUser($userId)->get();
        $count = 0;

        foreach ($conversations as $conversation) {
            $count += Message::where('conversation_id', (string) $conversation->_id)
                ->where('sender_id', '!=', $userId)
                ->where('is_deleted', false)
                ->get()
                ->filter(fn($msg) => !$msg->isReadBy($userId))
                ->count();
        }

        return $count;
    }

    public function getConversationUnreadCount(string $conversationId, int $userId): int
    {
        return Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $userId)
            ->where('is_deleted', false)
            ->get()
            ->filter(fn($msg) => !$msg->isReadBy($userId))
            ->count();
    }
}
