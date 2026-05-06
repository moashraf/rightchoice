@extends('layouts.admin')
@section('title', 'تواصل المستخدمين مع العقارات')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="row mb-2">
        <div class="col-12 d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="mt-3 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-phone-alt ml-2 text-primary"></i> تواصل المستخدمين مع العقارات
            </h4>
            <a href="{{ route('sitemanagement.reports.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-right ml-1"></i> العودة للتقارير
            </a>
        </div>
    </div>

    {{-- فلتر --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('sitemanagement.reports.userContacts') }}" class="form-inline flex-wrap gap-2">
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-search text-secondary ml-1"></i> بحث:
                    </label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="اسم / موبايل / ايميل"
                           value="{{ $search ?? '' }}" style="min-width:180px;">
                </div>
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-calendar-alt text-primary ml-1"></i> من:
                    </label>
                    <input type="date" name="from_date" class="form-control form-control-sm"
                           value="{{ $fromDate ?? '' }}">
                </div>
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-calendar-alt text-danger ml-1"></i> إلى:
                    </label>
                    <input type="date" name="to_date" class="form-control form-control-sm"
                           value="{{ $toDate ?? '' }}">
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-filter ml-1"></i> تصفية
                    </button>
                    <a href="{{ route('sitemanagement.reports.userContacts') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times ml-1"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- عدد النتائج --}}
    <div class="mb-3">
        <span class="badge badge-dark p-2" style="font-size:13px;">
            <i class="fas fa-users ml-1"></i>
            إجمالي العملاء: {{ $usersQuery->total() }}
        </span>
    </div>

    {{-- قائمة العملاء --}}
    @forelse($usersQuery as $user)
    @php
        $activePackage = $user->userpricing->sortByDesc('id')->first();
        $contactCount  = $user->contact->count();
        $totalPointsUsed = $user->contact->sum(function($c) {
            return optional($c->all_aqat_viw)->points_avail ?? 0;
        });
    @endphp
    <div class="card shadow-sm border-0 mb-4">
        {{-- رأس كارد العميل --}}
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap py-2"
             data-toggle="collapse" data-target="#contact-details-{{ $user->id }}"
             aria-expanded="false" aria-controls="contact-details-{{ $user->id }}"
             style="background: linear-gradient(135deg,#007bff11,#28a74511); border-right:5px solid #007bff; cursor:pointer;">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center ml-3"
                     style="width:48px;height:48px;background:#007bff22;font-size:22px;color:#007bff;">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h6 class="mb-0 font-weight-bold" style="font-size:16px;">
                        <a href="{{ route('sitemanagement.users.show', $user->id) }}"  target="_blank" class="text-dark text-decoration-none">
                            {{ $user->name }}
                        </a>
                    </h6>
                    <small class="text-muted">
                        <i class="fas fa-phone ml-1"></i>{{ $user->MOP ?? '—' }}
                        &nbsp;|&nbsp;
                        <i class="fas fa-envelope ml-1"></i>{{ $user->email ?? '—' }}
                    </small>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center mt-2 mt-md-0" style="gap:8px;">
                {{-- باقة المستخدم --}}
                @if($activePackage && $activePackage->pricing)
                <span class="badge p-2" style="background:#009688;color:#fff;font-size:12px;">
                    <i class="fas fa-gem ml-1"></i> الباقة: {{ $activePackage->pricing->type }}
                </span>
                <span class="badge badge-light border p-2" style="font-size:12px;">
                    <i class="fas fa-coins ml-1 text-warning"></i>
                    نقاط: {{ number_format($activePackage->current_points ?? 0) }} / {{ number_format($activePackage->start_points ?? 0) }}
                </span>
                <span class="badge badge-danger p-2" style="font-size:12px;">
                    <i class="fas fa-minus-circle ml-1"></i>
                    مستهلك: {{ number_format(($activePackage->start_points ?? 0) - ($activePackage->current_points ?? 0)) }}
                </span>
                @else
                <span class="badge badge-secondary p-2" style="font-size:12px;">
                    <i class="fas fa-gem ml-1"></i> لا توجد باقة
                </span>
                @endif
                <span class="badge badge-info p-2" style="font-size:12px;">
                    <i class="fas fa-phone-alt ml-1"></i>
                    عدد التواصلات: {{ $contactCount }}
                </span>
                <span class="badge badge-warning p-2" style="font-size:12px;">
                    <i class="fas fa-coins ml-1"></i>
                    إجمالي النقاط المستهلكة: {{ number_format($totalPointsUsed) }}
                </span>
                <i class="fas fa-chevron-down text-muted mr-2" style="transition:transform .3s;"></i>
            </div>
        </div>

        {{-- جدول العقارات التي تواصل معها العميل --}}
        <div class="collapse" id="contact-details-{{ $user->id }}">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>العقار</th>
                            <th>صاحب العقار</th>
                            <th style="width:110px;">سعر العقار</th>
                            <th style="width:110px;">نقاط مستهلكة</th>
                            <th style="width:140px;">تاريخ التواصل</th>
                            <th style="width:80px;">رابط</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->contact as $idx => $contact)
                        @php
                            $aqar = $contact->all_aqat_viw;
                            $owner = $aqar ? $aqar->user : null;
                            // try to get the package active at contact time (most recent before contact date)
                            $contactPackage = $user->userpricing
                                ->where('created_at', '<=', $contact->created_at)
                                ->sortByDesc('id')
                                ->first();
                        @endphp
                        <tr>
                            <td class="text-muted" style="font-size:12px;">{{ $idx + 1 }}</td>
                            <td>
                                @if($aqar)
                                <a href="{{ route('sitemanagement.aqars.show', $aqar->id) }}" target="_blank" class="text-decoration-none font-weight-bold text-dark">
                                    <i class="fas fa-building text-primary ml-1" style="font-size:12px;"></i>
                                    {{ Str::limit($aqar->title ?? 'بدون عنوان', 40) }}
                                </a>
                                <br>
                                <small class="text-muted">
                                    {{ $aqar->governrateq->governrate ?? '' }}
                                    @if($aqar->offerTypes) — {{ $aqar->offerTypes->type_offer ?? '' }} @endif
                                </small>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($owner)
                                <a href="{{ route('sitemanagement.users.show', $owner->id) }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-user-tie text-success ml-1" style="font-size:12px;"></i>
                                    {{ $owner->name }}
                                </a>
                                <br><small class="text-muted">{{ $owner->MOP ?? '' }}</small>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($aqar && $aqar->total_price)
                                <span class="text-success font-weight-bold">{{ number_format($aqar->total_price) }}</span>
                                <small class="text-muted">ج.م</small>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($aqar && $aqar->points_avail)
                                <span class="badge badge-warning p-1" style="font-size:12px;">
                                    <i class="fas fa-coins ml-1"></i>{{ number_format($aqar->points_avail) }}
                                </span>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <i class="fas fa-clock text-muted ml-1" style="font-size:11px;"></i>
                                <span style="font-size:12px;">{{ $contact->created_at ? $contact->created_at->format('d/m/Y H:i') : '—' }}</span>
                            </td>
                            <td>
                                @if($aqar)
                                <a href="{{ route('sitemanagement.aqars.show', $aqar->id) }}" target="_blank"
                                   class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">لا توجد سجلات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>{{-- end collapse --}}
    </div>{{-- end card --}}
    @empty
    <div class="card shadow-sm border-0">
        <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-info-circle fa-3x mb-3"></i>
            <p class="mb-0">لا توجد بيانات تواصل مع العقارات حالياً</p>
        </div>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($usersQuery->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $usersQuery->links() }}
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // rotate chevron when collapse opens/closes
    document.querySelectorAll('[data-toggle="collapse"]').forEach(function(header) {
        var target = document.querySelector(header.getAttribute('data-target'));
        if (!target) return;
        var icon = header.querySelector('.fa-chevron-down');
        target.addEventListener('show.bs.collapse', function() {
            if (icon) icon.style.transform = 'rotate(180deg)';
        });
        target.addEventListener('hide.bs.collapse', function() {
            if (icon) icon.style.transform = 'rotate(0deg)';
        });
        // jQuery fallback (Bootstrap 3/4 uses jQuery events)
        $(target).on('show.bs.collapse', function() {
            if (icon) icon.style.transform = 'rotate(180deg)';
        }).on('hide.bs.collapse', function() {
            if (icon) icon.style.transform = 'rotate(0deg)';
        });
    });
</script>
@endpush

