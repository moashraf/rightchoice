<x-layout>
    @section('title', $user->name . ' - العقارات')

    <section class="container py-5" dir="rtl">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center" style="gap:16px">
                <img src="{{ $user->profile_image ? url('/images/' . $user->profile_image) : url('/images/default-avatar.png') }}"
                     alt="{{ $user->name }}" width="96" height="96"
                     style="border-radius:50%;object-fit:cover">
                <div>
                    <h1 class="h3 mb-1">{{ $user->name }}</h1>
                    <p class="mb-0 text-muted">العقارات المنشورة: {{ $properties->total() }}</p>
                </div>
            </div>
        </div>

        <h2 class="h4 mb-3">عقارات {{ $user->name }}</h2>
        <div class="row">
            @forelse ($properties as $property)
                @php
                    $propertyImage = $property->mainImage ?? $property->firstImage;
                @endphp
                <div class="col-md-6 col-lg-4 mb-4">
                    <a href="{{ url('/' . app()->getLocale() . '/aqars/' . $property->slug) }}"
                       class="card h-100 text-decoration-none text-dark">
                        <img src="{{ $propertyImage ? url('/images/' . $propertyImage->img_url) : asset('images/FBO.png') }}"
                             alt="{{ $property->title }}" class="card-img-top"
                             style="height:220px;object-fit:cover" loading="lazy">
                        <div class="card-body">
                            <h3 class="h5 card-title">{{ $property->title }}</h3>
                            @if ($property->offerTypes)
                                <p class="card-text text-muted mb-0">{{ $property->offerTypes->type_offer }}</p>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12"><p>لا توجد عقارات منشورة حاليًا.</p></div>
            @endforelse
        </div>

        {{ $properties->links() }}
    </section>
</x-layout>
