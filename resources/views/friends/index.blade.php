<x-layout>
    @section('title')
        {{ trans('langsite.friends') }}
    @endsection

    <style>
        .friends-tabs .nav-link { color: #555; font-weight: 600; }
        .friends-tabs .nav-link.active { color: #3270fc; border-bottom: 2px solid #3270fc; }
        .friend-card { background: #fff; border-radius: 10px; padding: 15px; box-shadow: 0 1px 8px rgba(0,0,0,.06); display: flex; align-items: center; margin-bottom: 12px; }
        .friend-card img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-left: 15px; }
        .friend-card .friend-info { flex: 1; }
        .friend-card .friend-name { font-weight: 600; font-size: 15px; }
        .friend-card .friend-actions { display: flex; gap: 8px; }
        .search-users-input { border: 1px solid #ddd; border-radius: 25px; padding: 10px 20px; width: 100%; max-width: 400px; outline: none; }
        .pending-badge { background: #ff5722; color: #fff; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; margin-right: 5px; }
    </style>

    <section class="bg-light py-4">
        <div class="container">
            <h4 class="mb-4"><i class="fas fa-user-friends"></i> {{ trans('langsite.friends') }}</h4>

            {{-- Search bar --}}
            <div class="mb-4">
                <input type="text" id="searchUsersInput" class="search-users-input"
                       placeholder="{{ trans('langsite.search_users') }}...">
                <div id="searchResults" class="mt-2" style="display:none;"></div>
            </div>

            {{-- Tabs --}}
            <ul class="nav nav-tabs friends-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#friendsTab">
                        {{ trans('langsite.my_friends') }} ({{ $friends->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#pendingTab">
                        {{ trans('langsite.pending_requests') }}
                        @if($pendingRequests->count() > 0)
                            <span class="pending-badge">{{ $pendingRequests->count() }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#sentTab">
                        {{ trans('langsite.sent_requests') }} ({{ $sentRequests->count() }})
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                {{-- Friends --}}
                <div class="tab-pane fade show active" id="friendsTab">
                    @forelse($friends as $friend)
                        <div class="friend-card">
                            <img src="{{ $friend->profile_image ? url('/images/'.$friend->profile_image) : url('/images/default-avatar.png') }}" alt="">
                            <div class="friend-info">
                                <div class="friend-name">{{ $friend->name }}</div>
                            </div>
                            <div class="friend-actions">
                                <a href="{{ route('chat.index', ['locale' => app()->getLocale(), 'conversation' => '']) }}?user={{ $friend->id }}"
                                   class="btn btn-sm btn-primary" onclick="event.preventDefault(); startChat({{ $friend->id }})">
                                    <i class="fas fa-comment"></i> {{ trans('langsite.message') }}
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="removeFriend({{ $friend->id }})">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-4 text-muted">
                            <i class="fas fa-user-friends" style="font-size:40px;opacity:.3"></i>
                            <p class="mt-2">{{ trans('langsite.no_friends') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pending --}}
                <div class="tab-pane fade" id="pendingTab">
                    @forelse($pendingRequests as $request)
                        @php $sender = $request->getSender(); @endphp
                        <div class="friend-card" id="pending-{{ $request->_id }}">
                            <img src="{{ $sender && $sender->profile_image ? url('/images/'.$sender->profile_image) : url('/images/default-avatar.png') }}" alt="">
                            <div class="friend-info">
                                <div class="friend-name">{{ $sender ? $sender->name : trans('langsite.deleted_user') }}</div>
                            </div>
                            <div class="friend-actions">
                                <button class="btn btn-sm btn-success" onclick="acceptRequest('{{ $request->_id }}')">
                                    <i class="fas fa-check"></i> {{ trans('langsite.accept') }}
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="declineRequest('{{ $request->_id }}')">
                                    <i class="fas fa-times"></i> {{ trans('langsite.decline') }}
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-4 text-muted">
                            <p>{{ trans('langsite.no_pending_requests') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Sent --}}
                <div class="tab-pane fade" id="sentTab">
                    @forelse($sentRequests as $req)
                        @php $receiver = $req->getReceiver(); @endphp
                        <div class="friend-card">
                            <img src="{{ $receiver && $receiver->profile_image ? url('/images/'.$receiver->profile_image) : url('/images/default-avatar.png') }}" alt="">
                            <div class="friend-info">
                                <div class="friend-name">{{ $receiver ? $receiver->name : trans('langsite.deleted_user') }}</div>
                                <small class="text-muted">{{ trans('langsite.pending') }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-4 text-muted">
                            <p>{{ trans('langsite.no_sent_requests') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const locale = '{{ app()->getLocale() }}';

    // Search users
    let searchTimer;
    document.getElementById('searchUsersInput').addEventListener('input', function() {
        clearTimeout(searchTimer);
        const q = this.value.trim();
        const resultsDiv = document.getElementById('searchResults');

        if (q.length < 2) { resultsDiv.style.display = 'none'; return; }

        searchTimer = setTimeout(function() {
            fetch('/' + locale + '/friends/search?q=' + encodeURIComponent(q), {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                resultsDiv.style.display = 'block';
                if (!data.users || data.users.length === 0) {
                    resultsDiv.innerHTML = '<p class="text-muted">{{ trans("langsite.no_results") }}</p>';
                    return;
                }
                let html = '';
                data.users.forEach(function(u) {
                    html += '<div class="friend-card">';
                    html += '<img src="' + u.profile_image + '" alt="">';
                    html += '<div class="friend-info"><div class="friend-name">' + escapeHtml(u.name) + '</div></div>';
                    html += '<div class="friend-actions">';
                    if (u.is_friend) {
                        html += '<span class="badge bg-success">{{ trans("langsite.friends") }}</span>';
                    } else if (!u.is_blocked) {
                        html += '<button class="btn btn-sm btn-primary" onclick="sendFriendRequest(' + u.id + ', this)"><i class="fas fa-user-plus"></i> {{ trans("langsite.add_friend") }}</button>';
                    }
                    html += '</div></div>';
                });
                resultsDiv.innerHTML = html;
            });
        }, 500);
    });

    function sendFriendRequest(userId, btn) {
        btn.disabled = true;
        fetch('{{ route("friends.request", app()->getLocale()) }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ user_id: userId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { toastr.success(data.message); btn.innerHTML = '{{ trans("langsite.request_sent") }}'; }
            else { toastr.error(data.error); btn.disabled = false; }
        });
    }

    function acceptRequest(friendshipId) {
        fetch('/' + locale + '/friends/' + friendshipId + '/accept', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { toastr.success(data.message); document.getElementById('pending-' + friendshipId).remove(); }
            else { toastr.error(data.error); }
        });
    }

    function declineRequest(friendshipId) {
        fetch('/' + locale + '/friends/' + friendshipId + '/decline', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { toastr.success(data.message); document.getElementById('pending-' + friendshipId).remove(); }
            else { toastr.error(data.error); }
        });
    }

    function removeFriend(userId) {
        if (!confirm('{{ trans("langsite.confirm_remove_friend") }}')) return;
        fetch('{{ route("friends.remove", app()->getLocale()) }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ user_id: userId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { toastr.success(data.message); setTimeout(() => location.reload(), 1000); }
            else { toastr.error(data.message); }
        });
    }

    function startChat(userId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("chat.start", app()->getLocale()) }}';
        form.innerHTML = '<input type="hidden" name="_token" value="' + csrfToken + '"><input type="hidden" name="user_id" value="' + userId + '">';
        document.body.appendChild(form);
        form.submit();
    }

    function escapeHtml(text) { const d = document.createElement('div'); d.textContent = text; return d.innerHTML; }
    </script>
</x-layout>
