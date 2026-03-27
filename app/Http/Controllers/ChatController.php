<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\SendMessageRequest;
use App\Services\Chat\ChatService;
use App\Services\Chat\BlockService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected ChatService $chatService;
    protected BlockService $blockService;

    public function __construct(ChatService $chatService, BlockService $blockService)
    {
        $this->chatService = $chatService;
        $this->blockService = $blockService;
    }

    /**
     * Show chat page.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $conversations = $this->chatService->getUserConversations($user->id);

        // Enrich conversations with user info and unread counts
        $enriched = $conversations->getCollection()->map(function ($conv) use ($user) {
            $otherUser = $conv->getOtherUser($user->id);
            $conv->other_user = $otherUser;
            $conv->unread_count = $this->chatService->getConversationUnreadCount((string) $conv->_id, $user->id);
            return $conv;
        });

        $activeConversation = null;
        $messages = collect();

        if ($request->has('conversation')) {
            $activeConversation = \App\Models\Chat\Conversation::find($request->conversation);
            if ($activeConversation && in_array($user->id, $activeConversation->participants ?? [])) {
                $messages = $this->chatService->getMessages($request->conversation, $user->id);
                $this->chatService->markMessagesAsRead($request->conversation, $user->id);
                $activeConversation->other_user = $activeConversation->getOtherUser($user->id);
            }
        }

        return view('chat.index', compact('conversations', 'enriched', 'activeConversation', 'messages'));
    }

    /**
     * Start or get conversation with a user.
     */
    public function startConversation(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);
        $user = auth()->user();
        $otherUserId = (int) $request->user_id;

        if ($this->blockService->isBlocked($user->id, $otherUserId)) {
            return redirect()->back()->with('error', trans('langsite.cannot_message_blocked'));
        }

        $conversation = $this->chatService->getOrCreateConversation($user->id, $otherUserId);

        $locale = app()->getLocale();
        return redirect("/{$locale}/chat?conversation=" . $conversation->_id);
    }

    /**
     * Send message via AJAX.
     */
    public function sendMessage(SendMessageRequest $request)
    {
        $user = auth()->user();

        try {
            $conversation = $this->chatService->getOrCreateConversation($user->id, (int) $request->receiver_id);
            $message = $this->chatService->sendMessage((string) $conversation->_id, $user->id, $request->body);

            return response()->json([
                'success' => true,
                'message' => [
                    'id' => (string) $message->_id,
                    'body' => e($message->body),
                    'sender_id' => $message->sender_id,
                    'created_at' => $message->created_at->format('H:i'),
                    'is_mine' => true,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Get messages via AJAX (polling).
     */
    public function getMessages(Request $request, string $conversationId)
    {
        $user = auth()->user();

        try {
            $messages = $this->chatService->getMessages($conversationId, $user->id, 50);
            $this->chatService->markMessagesAsRead($conversationId, $user->id);

            $data = $messages->getCollection()->map(function ($msg) use ($user) {
                return [
                    'id' => (string) $msg->_id,
                    'body' => e($msg->body),
                    'sender_id' => $msg->sender_id,
                    'created_at' => $msg->created_at->format('H:i'),
                    'is_mine' => $msg->sender_id === $user->id,
                ];
            });

            return response()->json(['success' => true, 'messages' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 403);
        }
    }

    /**
     * Delete message via AJAX.
     */
    public function deleteMessage(Request $request, string $messageId)
    {
        $user = auth()->user();
        $result = $this->chatService->deleteMessage($messageId, $user->id);

        return response()->json(['success' => $result]);
    }

    /**
     * Get unread count via AJAX.
     */
    public function unreadCount()
    {
        $count = $this->chatService->getUnreadCount(auth()->id());
        return response()->json(['count' => $count]);
    }
}
