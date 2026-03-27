<x-layout>
    @section('title')
        {{ trans('langsite.community') }}
    @endsection

    <style>
        .post-card { background: #fff; border-radius: 12px; box-shadow: 0 1px 8px rgba(0,0,0,.06); margin-bottom: 20px; overflow: hidden; }
        .post-header { display: flex; align-items: center; padding: 15px 20px; }
        .post-header img { width: 42px; height: 42px; border-radius: 50%; margin-left: 12px; object-fit: cover; }
        .post-header .post-author { font-weight: 600; font-size: 14px; }
        .post-header .post-time { color: #888; font-size: 12px; }
        .post-content { padding: 0 20px 15px; font-size: 15px; line-height: 1.6; }
        .post-images { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 5px; padding: 0 20px 10px; }
        .post-images img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; cursor: pointer; }
        .post-actions { display: flex; border-top: 1px solid #eee; padding: 10px 20px; }
        .post-action-btn { flex: 1; text-align: center; padding: 8px; cursor: pointer; color: #555; font-size: 14px; border-radius: 8px; transition: background .2s; border: none; background: none; }
        .post-action-btn:hover { background: #f0f2f5; }
        .post-action-btn.liked { color: #3270fc; font-weight: 600; }
        .comments-section { padding: 0 20px 15px; display: none; }
        .comment-item { display: flex; margin-bottom: 10px; }
        .comment-item img { width: 32px; height: 32px; border-radius: 50%; margin-left: 10px; object-fit: cover; }
        .comment-bubble { background: #f0f2f5; border-radius: 18px; padding: 8px 14px; flex: 1; }
        .comment-bubble .comment-author { font-weight: 600; font-size: 12px; }
        .comment-bubble .comment-text { font-size: 13px; }
        .comment-input-area { display: flex; gap: 8px; margin-top: 10px; }
        .comment-input-area input { flex: 1; border: 1px solid #ddd; border-radius: 20px; padding: 8px 15px; font-size: 13px; outline: none; }
        .create-post-card { background: #fff; border-radius: 12px; box-shadow: 0 1px 8px rgba(0,0,0,.06); padding: 20px; margin-bottom: 20px; }
        .create-post-card textarea { width: 100%; border: none; resize: none; outline: none; font-size: 15px; min-height: 80px; }
        .create-post-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
        .post-menu { position: relative; }
        .post-menu-dropdown { position: absolute; left: 0; top: 100%; background: #fff; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.15); z-index: 10; display: none; min-width: 150px; }
        .post-menu-dropdown.show { display: block; }
        .post-menu-dropdown a { display: block; padding: 8px 15px; color: #333; text-decoration: none; font-size: 13px; }
        .post-menu-dropdown a:hover { background: #f0f2f5; }
    </style>

    <section class="bg-light py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h4 class="mb-4"><i class="fas fa-users"></i> {{ trans('langsite.community') }}</h4>

                    {{-- Create post --}}
                    <div class="create-post-card">
                        <form id="createPostForm" enctype="multipart/form-data">
                            @csrf
                            <textarea name="content" placeholder="{{ trans('langsite.whats_on_your_mind') }}..." required></textarea>
                            <div class="create-post-footer">
                                <div>
                                    <label class="btn btn-sm btn-outline-secondary" style="cursor:pointer">
                                        <i class="fas fa-image"></i> {{ trans('langsite.add_images') }}
                                        <input type="file" name="images[]" multiple accept="image/*" style="display:none" id="postImagesInput">
                                    </label>
                                    <span id="imageCount" class="text-muted ms-2" style="font-size:12px"></span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm px-4">{{ trans('langsite.publish') }}</button>
                            </div>
                        </form>
                    </div>

                    {{-- Posts feed --}}
                    @forelse($posts as $post)
                        @php $author = $post->author; @endphp
                        <div class="post-card" id="post-{{ $post->_id }}">
                            <div class="post-header">
                                <img src="{{ $author && $author->profile_image ? url('/images/'.$author->profile_image) : url('/images/default-avatar.png') }}" alt="">
                                <div style="flex:1">
                                    <div class="post-author">{{ $author ? $author->name : trans('langsite.deleted_user') }}</div>
                                    <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="post-menu">
                                    <button class="btn btn-sm" onclick="togglePostMenu(this)"><i class="fas fa-ellipsis-h"></i></button>
                                    <div class="post-menu-dropdown">
                                        @if($post->is_mine)
                                            <a href="#" onclick="deletePost('{{ $post->_id }}'); return false;"><i class="fas fa-trash"></i> {{ trans('langsite.delete') }}</a>
                                        @else
                                            <a href="#" onclick="reportUserModal({{ $author ? $author->id : 0 }}, 'post', '{{ $post->_id }}'); return false;"><i class="fas fa-flag"></i> {{ trans('langsite.report') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="post-content">{!! nl2br(e($post->content)) !!}</div>

                            @if($post->images && count($post->images) > 0)
                                <div class="post-images">
                                    @foreach($post->images as $img)
                                        <img src="{{ url('/uploads/posts/'.$img) }}" alt="" onclick="window.open(this.src)">
                                    @endforeach
                                </div>
                            @endif

                            <div class="post-actions">
                                <button class="post-action-btn {{ $post->is_liked ? 'liked' : '' }}"
                                        onclick="toggleLike('{{ $post->_id }}', this)">
                                    <i class="fas fa-heart"></i>
                                    <span class="likes-count">{{ $post->likes_count ?? 0 }}</span>
                                </button>
                                <button class="post-action-btn" onclick="toggleComments('{{ $post->_id }}')">
                                    <i class="fas fa-comment"></i>
                                    <span>{{ $post->comments_count ?? 0 }}</span> {{ trans('langsite.comments') }}
                                </button>
                            </div>

                            <div class="comments-section" id="comments-{{ $post->_id }}">
                                <div class="comments-list" id="comments-list-{{ $post->_id }}"></div>
                                <div class="comment-input-area">
                                    <input type="text" placeholder="{{ trans('langsite.write_comment') }}..."
                                           onkeypress="if(event.key==='Enter') addComment('{{ $post->_id }}', this)">
                                    <button class="btn btn-sm btn-primary" onclick="addComment('{{ $post->_id }}', this.previousElementSibling)">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-5 text-muted">
                            <i class="fas fa-newspaper" style="font-size:50px;opacity:.3"></i>
                            <p class="mt-3">{{ trans('langsite.no_posts') }}</p>
                        </div>
                    @endforelse

                    @if($posts->hasMorePages())
                        <div class="text-center mt-3">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('components.report-modal')

    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const locale = '{{ app()->getLocale() }}';

    // Image count
    document.getElementById('postImagesInput').addEventListener('change', function() {
        document.getElementById('imageCount').textContent = this.files.length > 0 ? this.files.length + ' {{ trans("langsite.images_selected") }}' : '';
    });

    // Create post
    document.getElementById('createPostForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route("posts.store", app()->getLocale()) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { toastr.success(data.message); setTimeout(() => location.reload(), 1000); }
            else { toastr.error(data.error || '{{ trans("langsite.error_occurred") }}'); }
        })
        .catch(() => toastr.error('{{ trans("langsite.error_occurred") }}'));
    });

    function toggleLike(postId, btn) {
        fetch('/' + locale + '/community/posts/' + postId + '/like', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.classList.toggle('liked', data.liked);
                btn.querySelector('.likes-count').textContent = data.likes_count;
            }
        });
    }

    function toggleComments(postId) {
        const section = document.getElementById('comments-' + postId);
        if (section.style.display === 'none' || !section.style.display) {
            section.style.display = 'block';
            loadComments(postId);
        } else {
            section.style.display = 'none';
        }
    }

    function loadComments(postId) {
        const listEl = document.getElementById('comments-list-' + postId);
        fetch('/' + locale + '/community/posts/' + postId + '/comments', {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                listEl.innerHTML = '';
                data.comments.forEach(function(c) {
                    listEl.innerHTML += '<div class="comment-item">' +
                        '<img src="' + c.user_image + '" alt="">' +
                        '<div class="comment-bubble"><div class="comment-author">' + escapeHtml(c.user_name) + '</div>' +
                        '<div class="comment-text">' + escapeHtml(c.content) + '</div>' +
                        '<small class="text-muted">' + c.created_at + '</small></div>' +
                        (c.is_mine ? '<button class="btn btn-sm text-danger" onclick="deleteComment(\'' + c.id + '\', \'' + postId + '\')"><i class="fas fa-trash-alt"></i></button>' : '') +
                        '</div>';
                });
            }
        });
    }

    function addComment(postId, input) {
        if (!input.value.trim()) return;
        const content = input.value.trim();
        input.value = '';

        fetch('/' + locale + '/community/posts/' + postId + '/comment', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ content: content })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { loadComments(postId); }
            else { toastr.error(data.error || '{{ trans("langsite.error_occurred") }}'); }
        });
    }

    function deleteComment(commentId, postId) {
        fetch('/' + locale + '/community/comments/' + commentId, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { loadComments(postId); }
        });
    }

    function deletePost(postId) {
        if (!confirm('{{ trans("langsite.confirm_delete_post") }}')) return;
        fetch('/' + locale + '/community/posts/' + postId, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { document.getElementById('post-' + postId).remove(); toastr.success('{{ trans("langsite.post_deleted") }}'); }
        });
    }

    function togglePostMenu(btn) {
        const dropdown = btn.nextElementSibling;
        document.querySelectorAll('.post-menu-dropdown.show').forEach(d => { if (d !== dropdown) d.classList.remove('show'); });
        dropdown.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.post-menu')) {
            document.querySelectorAll('.post-menu-dropdown.show').forEach(d => d.classList.remove('show'));
        }
    });

    function escapeHtml(text) { const d = document.createElement('div'); d.textContent = text; return d.innerHTML; }
    </script>
</x-layout>
