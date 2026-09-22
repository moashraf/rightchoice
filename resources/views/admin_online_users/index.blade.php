@extends('layouts.admin')

@section('title', 'المستخدمون المتصلون الآن')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-wifi text-success"></i> المستخدمون المتصلون الآن</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('sitemanagement.onlineUsers.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sync-alt"></i> تحديث
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalOnline }}</h3>
                        <p>مستخدمون مسجلون متصلون</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $appOnline }}</h3>
                        <p>من التطبيق (API)</p>
                    </div>
                    <div class="icon"><i class="fas fa-mobile-alt"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $webOnline }}</h3>
                        <p>من الموقع (ديسكتوب / موبايل)</p>
                    </div>
                    <div class="icon"><i class="fas fa-desktop"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $guestSessions }}</h3>
                        <p>زوار بدون تسجيل دخول</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-secret"></i></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">
                    <i class="fas fa-circle text-light mr-1" style="font-size:10px;"></i>
                    المستخدمون المتصلون ({{ $totalOnline }})
                </h3>
            </div>
            <div class="card-body p-0">
                @if($totalOnline > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الهاتف</th>
                                    <th>مصدر الدخول</th>
                                    <th>الجهاز</th>
                                    <th>عنوان IP</th>
                                    <th>الموقع التقريبي</th>
                                    <th>آخر نشاط</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($onlineUsers as $index => $online)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <i class="fas fa-circle text-success mr-1" style="font-size:8px;"></i>
                                            <strong>{{ $online->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $online->email }}</small>
                                        </td>
                                        <td>{{ $online->phone }}</td>
                                        <td>
                                            @foreach($online->sources as $source)
                                                @if($source === 'التطبيق')
                                                    <span class="badge badge-primary mb-1">
                                                        <i class="fas fa-mobile-alt"></i> التطبيق
                                                    </span>
                                                @elseif($source === 'الموقع (موبايل)')
                                                    <span class="badge badge-info mb-1">
                                                        <i class="fas fa-globe"></i> الموقع (موبايل)
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary mb-1">
                                                        <i class="fas fa-desktop"></i> الموقع (ديسكتوب)
                                                    </span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @forelse($online->devices as $device)
                                                <small class="d-block">{{ $device }}</small>
                                            @empty
                                                <span class="text-muted">-</span>
                                            @endforelse
                                        </td>
                                        <td><code>{{ $online->ip_address }}</code></td>
                                        <td>
                                            @if($online->location)
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                                {{ $online->location->label }}
                                                @if($online->location->isp)
                                                    <br><small class="text-muted">{{ $online->location->isp }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">غير معروف</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span title="{{ $online->last_activity->format('Y-m-d H:i:s') }}">
                                                {{ $online->last_activity->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('sitemanagement.onlineUsers.show', $online->user_id) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="تفاصيل أكثر">
                                                <i class="fas fa-search-plus"></i>
                                            </a>
                                            <a href="{{ route('sitemanagement.users.show', $online->user_id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="عرض الملف الشخصي">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted">لا يوجد مستخدمون متصلون حالياً</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center text-muted mt-2 mb-4">
            <small>
                <i class="fas fa-info-circle"></i>
                التطبيق = طلبات الـ API. الموقع = جلسة المتصفح. الموقع التقريبي من عنوان الـ IP (تقريبي وليس GPS).
                يتم تحديث الصفحة كل 30 ثانية.
            </small>
        </div>
    </div>
@endsection

@push('page_scripts')
<script>
    setTimeout(function() {
        window.location.reload();
    }, 30000);
</script>
@endpush
