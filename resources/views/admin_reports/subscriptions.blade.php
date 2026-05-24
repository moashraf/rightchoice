@extends('layouts.admin')
@section('title', 'اشتراكات الباقات')

@section('content')
<div class="container-fluid">

    <div class="row mb-2">
        <div class="col-12 d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="mt-3 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-gem ml-2" style="color:#009688;"></i> اشتراكات الباقات
            </h4>
            <a href="{{ route('sitemanagement.reports.index', request()->only('from_date', 'to_date')) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-right ml-1"></i> العودة للتقارير
            </a>
        </div>
    </div>

    {{-- الفلاتر --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('sitemanagement.reports.subscriptions') }}" class="form-inline flex-wrap gap-2">
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-search text-secondary ml-1"></i> بحث:
                    </label>
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="اسم / موبايل / ايميل / باقة"
                           value="{{ $search ?? '' }}" style="min-width:190px;">
                </div>

                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-gem text-success ml-1"></i> الباقة:
                    </label>
                    <select name="pricing_id" class="form-control form-control-sm" style="min-width:150px;">
                        <option value="">كل الباقات</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ (string)($pricingId ?? '') === (string)$package->id ? 'selected' : '' }}>
                                {{ $package->type }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-calendar-alt text-primary ml-1"></i> من:
                    </label>
                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ $fromDate ?? '' }}">
                </div>

                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-calendar-alt text-danger ml-1"></i> إلى:
                    </label>
                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ $toDate ?? '' }}">
                </div>

                <div class="mb-2">
                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-filter ml-1"></i> تصفية
                    </button>
                    <a href="{{ route('sitemanagement.reports.subscriptions') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times ml-1"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ملخص --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm border-0 h-100" style="border-right:5px solid #009688;">
                <div class="card-body">
                    <p class="text-muted mb-1">إجمالي الاشتراكات</p>
                    <h3 class="mb-0" style="color:#009688;">{{ number_format($summary['total']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm border-0 h-100" style="border-right:5px solid #28a745;">
                <div class="card-body">
                    <p class="text-muted mb-1">اشتراكات نشطة</p>
                    <h3 class="mb-0 text-success">{{ number_format($summary['active']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm border-0 h-100" style="border-right:5px solid #6c757d;">
                <div class="card-body">
                    <p class="text-muted mb-1">مستخدمون مشتركين</p>
                    <h3 class="mb-0 text-secondary">{{ number_format($summary['unique_users']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm border-0 h-100" style="border-right:5px solid #ffc107;">
                <div class="card-body">
                    <p class="text-muted mb-1">إجمالي النقاط الحالية</p>
                    <h3 class="mb-0 text-warning">{{ number_format($summary['current_points']) }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول الاشتراكات --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap">
            <strong>
                <i class="fas fa-list ml-1"></i> تفاصيل الاشتراكات
            </strong>
            <span class="badge badge-dark p-2">عدد النتائج: {{ number_format($subscriptions->total()) }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>المستخدم</th>
                            <th>الموبايل</th>
                            <th>الباقة</th>
                            <th>سعر الباقة</th>
                            <th>نقاط البداية</th>
                            <th>النقاط الحالية</th>
                            <th>النقاط المستخدمة</th>
                             <th>تاريخ الاشتراك</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->id }}</td>
                                <td>
                                    @if($subscription->user)
                                        <a href="{{ route('sitemanagement.users.show', $subscription->user->id) }}">
                                            {{ $subscription->user->name }}
                                        </a>
                                        <br>
                                        <small class="text-muted">{{ $subscription->user->email }}</small>
                                    @else
                                        <span class="text-muted">مستخدم محذوف / غير موجود</span>
                                    @endif
                                </td>
                                <td>{{ optional($subscription->user)->MOP ?? '-' }}</td>
                                <td>{{ optional($subscription->pricing)->type ?? 'غير محدد' }}</td>
                                <td>
                                    @if($subscription->pricing)
                                        {{ number_format($subscription->pricing->price, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ number_format($subscription->start_points ?? 0) }}</td>
                                <td>{{ number_format($subscription->current_points ?? 0) }}</td>
                                <td>{{ number_format($subscription->sub_points ?? 0) }}</td>

                                <td>
                                    @if($subscription->created_at)
                                        {{ $subscription->created_at->format('Y-m-d H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    لا توجد اشتراكات مطابقة للفلاتر الحالية.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($subscriptions->hasPages())
            <div class="card-footer bg-white d-flex justify-content-center">
                {!! $subscriptions->links() !!}
            </div>
        @endif
    </div>

</div>
@endsection

