@foreach (Illuminate\Support\Arr::wrap(session('flash_notification', [])) as $message)
    @if ($message['overlay'] ?? false)
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'] ?? '',
            'body'       => $message['message'] ?? ''
        ])
    @else
        <div class="alert
                    alert-{{ $message['level'] ?? 'info' }}
                    {{ ($message['important'] ?? false) ? 'alert-important' : '' }}"
                    role="alert"
        >
            @if ($message['important'] ?? false)
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                >&times;</button>
            @endif

            {!! $message['message'] ?? '' !!}
        </div>
    @endif
@endforeach

@php session()->forget('flash_notification') @endphp
