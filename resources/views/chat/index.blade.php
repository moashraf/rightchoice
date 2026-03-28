<x-layout>
    @section('title')
        {{ trans('langsite.messages') }}
    @endsection

    <style>
        .chat-wrapper { display: flex; height: calc(100vh - 200px); min-height: 500px; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,.08); margin-top: 20px; }
        .chat-sidebar { width: 320px; border-left: 1px solid #e9ecef; overflow-y: auto; background: #f8f9fa; flex-shrink: 0; }
        .chat-main { flex: 1; display: flex; flex-direction: column; }
        .chat-header { padding: 15px 20px; border-bottom: 1px solid #e9ecef; background: #fff; display: flex; align-items: center; }
        .chat-header img { width: 40px; height: 40px; border-radius: 50%; margin-left: 12px; object-fit: cover; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 20px; background: #f0f2f5; }
        .chat-input-area { padding: 15px 20px; border-top: 1px solid #e9ecef; background: #fff; display: flex; gap: 10px; }
        .chat-input-area input { flex: 1; border: 1px solid #ddd; border-radius: 25px; padding: 10px 20px; outline: none; font-size: 14px; }
        .chat-input-area button { background: #3270fc; color: #fff; border: none; border-radius: 50%; width: 42px; height: 42px; cursor: pointer; }
        .conversation-item { display: flex; align-items: center; padding: 12px 15px; border-bottom: 1px solid #e9ecef; cursor: pointer; transition: background .2s; text-decoration: none; color: inherit; }
        .conversation-item:hover, .conversation-item.active { background: #e3e8f0; text-decoration: none; color: inherit; }
        .conversation-item img { width: 45px; height: 45px; border-radius: 50%; margin-left: 12px; object-fit: cover; }
        .conversation-item .conv-info { flex: 1; min-width: 0; }
        .conversation-item .conv-name { font-weight: 600; font-size: 14px; margin-bottom: 2px; }
        .conversation-item .conv-last-msg { color: #888; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .conversation-item .unread-badge { background: #3270fc; color: #fff; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; }
        .msg-bubble { max-width: 65%; padding: 10px 16px; margin-bottom: 8px; border-radius: 18px; font-size: 14px; line-height: 1.5; word-wrap: break-word; position: relative; }
        .msg-mine { background: #3270fc; color: #fff; margin-left: auto; border-bottom-left-radius: 4px; }
        .msg-other { background: #fff; color: #333; margin-right: auto; border-bottom-right-radius: 4px; }
        .msg-time { font-size: 10px; opacity: .7; margin-top: 3px; }
        .msg-mine .msg-time { text-align: left; }
        .msg-other .msg-time { text-align: right; }
        .no-conversation { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #888; }
        .no-conversation i { font-size: 60px; margin-bottom: 15px; opacity: .3; }
        .sidebar-search { padding: 12px; border-bottom: 1px solid #e9ecef; }
        .sidebar-search input { width: 100%; border: 1px solid #ddd; border-radius: 20px; padding: 8px 15px; font-size: 13px; outline: none; }
        @media (max-width: 768px) {
            .chat-sidebar { width: 100%; position: absolute; z-index: 10; height: 100%; }
            .chat-wrapper { position: relative; }
            .chat-sidebar.hidden-mobile { display: none; }
        }
    </style>

    <section class="bg-light py-4">
        <div class="container">
            <div class="chat-wrapper" id="chatWrapper">
                {{-- Sidebar --}}
                <div class="chat-sidebar" id="chatSidebar">
                    <div class="sidebar-search">
                        <input type="text" id="searchConversations" placeholder="{{ trans('langsite.search') }}...">
                    </div>
                    <div id="conversationList">
                        @forelse($enriched as $conv)
                            @php
                                $other = $conv->other_user;
                                $isActive = $activeConversation && (string)$activeConversation->_id === (string)$conv->_id;
                            @endphp
                            <a href="{{ route('chat.index', ['locale' => app()->getLocale(), 'conversation' => $conv->_id]) }}"
                               class="conversation-item {{ $isActive ? 'active' : '' }}"
                               data-name="{{ $other ? $other->name : '' }}">
                                <img src="{{ $other && $other->profile_image ? url('/images/'.$other->profile_image) : url('/images/default-avatar.png') }}" alt="">
                                <div class="conv-info">
                                    <div class="conv-name">{{ $other ? $other->name : trans('langsite.deleted_user') }}</div>
                                    <div class="conv-last-msg">{{ $conv->last_message['body'] ?? '' }}</div>
                                </div>
                                @if($conv->unread_count > 0)
                                    <span class="unread-badge">{{ $conv->unread_count }}</span>
                                @endif
                            </a>
                        @empty
                            <div class="text-center p-4 text-muted">
                                <i class="fas fa-comments" style="font-size:30px;opacity:.3"></i>
                                <p class="mt-2">{{ trans('langsite.no_conversations') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Main chat area --}}
                <div class="chat-main">
                    @if($activeConversation)
                        @php $otherUser = $activeConversation->other_user; @endphp
                        <div class="chat-header">
                            <img src="{{ $otherUser && $otherUser->profile_image ? url('/images/'.$otherUser->profile_image) : url('/images/default-avatar.png') }}" alt="">
                            <div>
                                <strong>{{ $otherUser ? $otherUser->name : trans('langsite.deleted_user') }}</strong>
                            </div>
                            <div class="ms-auto d-flex gap-2">
                                <button class="btn btn-sm btn-outline-danger" onclick="reportUserModal({{ $otherUser ? $otherUser->id : 0 }}, 'user')" title="{{ trans('langsite.report') }}">
                                    <i class="fas fa-flag"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-dark" onclick="blockUserAction({{ $otherUser ? $otherUser->id : 0 }})" title="{{ trans('langsite.block') }}">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </div>

                        <div class="chat-messages" id="chatMessages">
                            @foreach($messages->reverse() as $msg)
                                <div class="msg-bubble {{ $msg->sender_id === auth()->id() ? 'msg-mine' : 'msg-other' }}">
                                    {!! e($msg->body) !!}
                                    <div class="msg-time">{{ $msg->created_at->format('H:i') }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="chat-input-area">
                            <input type="text" id="messageInput" placeholder="{{ trans('langsite.type_message') }}..."
                                   data-conversation="{{ $activeConversation->_id }}"
                                   data-receiver="{{ $otherUser ? $otherUser->id : '' }}">
                            <button type="button" id="sendMessageBtn"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    @else
                        <div class="no-conversation">
                            <i class="fas fa-comments"></i>
                            <h5>{{ trans('langsite.select_conversation') }}</h5>
                            <p class="text-muted">{{ trans('langsite.select_conversation_hint') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('components.report-modal')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;

        // Search conversations
        const searchInput = document.getElementById('searchConversations');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const q = this.value.toLowerCase();
                document.querySelectorAll('.conversation-item').forEach(function(item) {
                    const name = item.getAttribute('data-name') || '';
                    item.style.display = name.toLowerCase().includes(q) ? '' : 'none';
                });
            });
        }

        // Send message
        const sendBtn = document.getElementById('sendMessageBtn');
        const msgInput = document.getElementById('messageInput');

        function sendMessage() {
            if (!msgInput || !msgInput.value.trim()) return;

            const body = msgInput.value.trim();
            const receiverId = msgInput.dataset.receiver;
            msgInput.value = '';

            // Optimistic UI
            const bubble = document.createElement('div');
            bubble.className = 'msg-bubble msg-mine';
            bubble.innerHTML = escapeHtml(body) + '<div class="msg-time">' + new Date().toLocaleTimeString('ar', {hour:'2-digit', minute:'2-digit'}) + '</div>';
            chatMessages.appendChild(bubble);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            fetch('{{ route("chat.send", app()->getLocale()) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ body: body, receiver_id: receiverId })
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) { toastr.error(data.error || '{{ trans("langsite.error_occurred") }}'); }
            })
            .catch(() => toastr.error('{{ trans("langsite.error_occurred") }}'));
        }

        if (sendBtn) sendBtn.addEventListener('click', sendMessage);
        if (msgInput) msgInput.addEventListener('keypress', function(e) { if (e.key === 'Enter') sendMessage(); });

        // Poll for new messages every 5 seconds
        const convId = msgInput ? msgInput.dataset.conversation : null;
        if (convId) {
            setInterval(function() {
                fetch('{{ url(app()->getLocale()) }}/chat/' + convId + '/messages', {
                    headers: { 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success && data.messages) {
                        chatMessages.innerHTML = '';
                        data.messages.reverse().forEach(function(msg) {
                            const div = document.createElement('div');
                            div.className = 'msg-bubble ' + (msg.is_mine ? 'msg-mine' : 'msg-other');
                            div.innerHTML = msg.body + '<div class="msg-time">' + msg.created_at + '</div>';
                            chatMessages.appendChild(div);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                });
            }, 5000);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(text));
            return div.innerHTML;
        }
    });

    function blockUserAction(userId) {
        if (!confirm('{{ trans("langsite.confirm_block") }}')) return;
        fetch('{{ route("block.store", app()->getLocale()) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { toastr.success(data.message); setTimeout(() => location.reload(), 1000); }
            else { toastr.error(data.error); }
        });
    }
    </script>
</x-layout>
