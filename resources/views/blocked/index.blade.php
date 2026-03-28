<x-layout>
    @section('title')
        {{ trans('langsite.blocked_users') }}
    @endsection

    <section class="bg-light py-4">
        <div class="container">
            <h4 class="mb-4"><i class="fas fa-ban"></i> {{ trans('langsite.blocked_users') }}</h4>

            @forelse($blockedUsers as $user)
                <div class="card mb-3" id="blocked-{{ $user->id }}">
                    <div class="card-body d-flex align-items-center">
                        <img src="{{ $user->profile_image ? url('/images/'.$user->profile_image) : url('/images/default-avatar.png') }}"
                             alt="" class="rounded-circle" style="width:45px;height:45px;object-fit:cover;margin-left:15px;">
                        <div class="flex-grow-1">
                            <strong>{{ $user->name }}</strong>
                        </div>
                        <button class="btn btn-sm btn-outline-success" onclick="unblockUser({{ $user->id }})">
                            <i class="fas fa-unlock"></i> {{ trans('langsite.unblock') }}
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center p-5 text-muted">
                    <i class="fas fa-shield-alt" style="font-size:40px;opacity:.3"></i>
                    <p class="mt-2">{{ trans('langsite.no_blocked_users') }}</p>
                </div>
            @endforelse
        </div>
    </section>

    <script>
    function unblockUser(userId) {
        if (!confirm('{{ trans("langsite.confirm_unblock") }}')) return;
        fetch('{{ route("block.destroy", app()->getLocale()) }}', {
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
            if (data.success) {
                toastr.success(data.message);
                document.getElementById('blocked-' + userId).remove();
            } else {
                toastr.error(data.message || '{{ trans("langsite.error_occurred") }}');
            }
        });
    }
    </script>
</x-layout>
