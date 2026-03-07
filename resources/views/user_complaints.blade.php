<x-layout>

@section('title')
    شكاواي
@endsection

<section id="profile-info" class="bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">

                <div class="col-md-10 offset-md-1 mt-5">

                    {{-- Header --}}
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0">
                            <i class="fa fa-exclamation-circle ml-2 text-warning"></i>
                            شكاواي
                        </h3>
                        <a href="{{ URL::to(Config::get('app.locale').'/dashboard') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-right ml-1"></i> العودة للصفحة الشخصية
                        </a>
                    </div>

                    {{-- Flash Message --}}
                    @if(session('complaint_deleted'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle ml-1"></i> {{ session('complaint_deleted') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    {{-- Stats Badge --}}
                    <div class="mb-3">
                        <span class="badge badge-warning p-2" style="font-size:14px;">
                            إجمالي الشكاوى: {{ $complaints->total() }}
                        </span>
                    </div>

                    {{-- Complaints List --}}
                    @forelse($complaints as $complaint)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">

                                    {{-- Aqar Info --}}
                                    <div class="col-md-7">
                                        <h6 class="font-weight-bold mb-1">
                                            <i class="fa fa-home ml-1 text-primary"></i>
                                            @if($complaint->aqarinfo)
                                                {{ $complaint->aqarinfo->title ?? 'عقار #' . $complaint->aqars_id }}
                                            @else
                                                <span class="text-muted">عقار #{{ $complaint->aqars_id }}</span>
                                            @endif
                                        </h6>
                                        <p class="mb-1 text-muted" style="font-size:13px;">
                                            <i class="fa fa-comment ml-1"></i>
                                            <strong>الشكوى:</strong> {{ $complaint->message }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="fa fa-calendar ml-1"></i>
                                            {{ $complaint->created_at ? $complaint->created_at->format('Y-m-d H:i') : '-' }}
                                        </small>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-3 text-center mt-2 mt-md-0">
                                        @php $statusVal = $complaint->status; @endphp
                                        @if($statusVal == 1 || $statusVal == 'pending' || $statusVal === null)
                                            <span class="badge badge-warning p-2" style="font-size:13px;">
                                                <i class="fa fa-clock ml-1"></i> قيد المراجعة
                                            </span>
                                        @elseif($statusVal == 2 || $statusVal == 'inprogress')
                                            <span class="badge badge-info p-2" style="font-size:13px;">
                                                <i class="fa fa-spinner ml-1"></i> جاري المعالجة
                                            </span>
                                        @elseif($statusVal == 3 || $statusVal == 'solved')
                                            <span class="badge badge-success p-2" style="font-size:13px;">
                                                <i class="fa fa-check ml-1"></i> تم الحل
                                            </span>
                                        @else
                                            <span class="badge badge-secondary p-2" style="font-size:13px;">
                                                {{ $statusVal ?? 'غير محدد' }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Delete Button --}}
                                    <div class="col-md-2 text-center mt-2 mt-md-0">
                                        <form action="{{ route('user_complaints.delete', ['id' => $complaint->id]) }}"
                                              method="POST"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذه الشكوى؟')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="حذف الشكوى">
                                                <i class="fa fa-trash ml-1"></i> حذف
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                                <h5 class="text-muted">لا توجد شكاوى مسجلة حتى الآن.</h5>
                            </div>
                        </div>
                    @endforelse

                    {{-- Pagination --}}
                    @if($complaints->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $complaints->links() }}
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</section>

</x-layout>
