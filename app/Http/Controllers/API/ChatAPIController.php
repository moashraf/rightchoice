<?php

namespace App\Http\Controllers\API;

use App\Services\Chat\ChatService;
use App\Services\Chat\BlockService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

/**
 * Chat API Controller.
 */
class ChatAPIController extends AppBaseController
{
    protected ChatService $chatService;
    protected BlockService $blockService;

    public function __construct(ChatService $chatService, BlockService $blockService)
    {
        $this->chatService = $chatService;
        $this->blockService = $blockService;
    }

    /**
     * GET /api/chat/conversations
     */
    public function conversations(Request $request): JsonResponse
    {
        $user = $request->user();
        $conversations = $this->chatService->getUserConversations($user->id);

        $enriched = $conversations->getCollection()->map(function ($conv) use ($user) {
            $otherUser = $conv->getOtherUser($user->id);
            return [
                'id'           => (string) $conv->_id,
                'other_user'   => $otherUser ? [
                    'id'            => $otherUser->id,
                    'name'          => $otherUser->name,
                    'profile_image' => $otherUser->profile_image_url ?? null,
                ] : null,
                'last_message' => $conv->last_message ?? null,
                'updated_at'   => $conv->updated_at?->toDateTimeString(),
                'unread_count' => $this->chatService->getConversationUnreadCount((string) $conv->_id, $user->id),
            ];
        });

        return $this->sendResponse([
            'conversations' => $enriched,
            'pagination'    => [
                'current_page' => $conversations->currentPage(),
                'last_page'    => $conversations->lastPage(),
                'total'        => $conversations->total(),
            ],
        ], 'Conversations retrieved successfully');
    }

    /**
     * POST /api/chat/start
     */
    public function startConversation(Request $request): JsonResponse
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

        $user = $request->user();
        $otherUserId = (int) $request->user_id;

        if ($this->blockService->isBlocked($user->id, $otherUserId)) {
            return $this->sendError('Cannot message this user', 403);
        }

        $conversation = $this->chatService->getOrCreateConversation($user->id, $otherUserId);

        return $this->sendResponse([
            'conversation_id' => (string) $conversation->_id,
        ], 'Conversation started successfully');
    }

    /**
     * POST /api/chat/send
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|integer|exists:users,id',
            'body'        => 'required|string|max:2000',
        ], [
            'receiver_id.required' => 'حقل معرف المستلم مطلوب.',
            'receiver_id.integer'  => 'معرف المستلم يجب أن يكون رقمًا صحيحًا.',
            'receiver_id.exists'   => 'المستلم غير موجود في النظام.',
            'body.required'        => 'حقل نص الرسالة مطلوب.',
            'body.string'          => 'نص الرسالة يجب أن يكون نصاً.',
            'body.max'             => 'نص الرسالة يجب ألا يتجاوز 2000 حرف.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $user = $request->user();

        try {
            $conversation = $this->chatService->getOrCreateConversation($user->id, (int) $request->receiver_id);
            $message = $this->chatService->sendMessage((string) $conversation->_id, $user->id, $request->body);

            return $this->sendResponse([
                'id'         => (string) $message->_id,
                'body'       => e($message->body),
                'sender_id'  => $message->sender_id,
                'created_at' => $message->created_at->format('Y-m-d H:i:s'),
            ], 'Message sent successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * GET /api/chat/{conversationId}/messages
     */
    public function getMessages(Request $request, string $conversationId): JsonResponse
    {
        $user = $request->user();

        try {
            $messages = $this->chatService->getMessages($conversationId, $user->id, 50);
            $this->chatService->markMessagesAsRead($conversationId, $user->id);

            $data = $messages->getCollection()->map(function ($msg) use ($user) {
                return [
                    'id'         => (string) $msg->_id,
                    'body'       => e($msg->body),
                    'sender_id'  => $msg->sender_id,
                    'created_at' => $msg->created_at->format('Y-m-d H:i:s'),
                    'is_mine'    => $msg->sender_id === $user->id,
                ];
            });

            return $this->sendResponse(['messages' => $data], 'Messages retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 403);
        }
    }

    /**
     * DELETE /api/chat/message/{messageId}
     */
    public function deleteMessage(Request $request, string $messageId): JsonResponse
    {
        $result = $this->chatService->deleteMessage($messageId, $request->user()->id);

        return $result
            ? $this->sendSuccess('Message deleted successfully')
            : $this->sendError('Failed to delete message', 400);
    }

    /**
     * GET /api/chat/unread-count
     */
    public function unreadCount(Request $request): JsonResponse
    {
        $count = $this->chatService->getUnreadCount($request->user()->id);

        return $this->sendResponse(['count' => $count], 'Unread count retrieved');
    }
}

