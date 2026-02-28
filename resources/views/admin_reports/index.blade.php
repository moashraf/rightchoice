@extends('layouts.admin')
@section('title', 'التقارير والإحصائيات')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
            <h4 class="mt-3 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-chart-line ml-2"></i> التقارير والإحصائيات
            </h4>
        </div>
    </div>

    {{-- فلتر التاريخ --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('sitemanagement.reports.index') }}" class="form-inline flex-wrap gap-2">
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-calendar-alt text-primary ml-1"></i> من تاريخ:
                    </label>
                    <input type="date" name="from_date" class="form-control form-control-sm"
                           value="{{ $fromDate ?? '' }}">
                </div>
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-calendar-alt text-danger ml-1"></i> إلى تاريخ:
                    </label>
                    <input type="date" name="to_date" class="form-control form-control-sm"
                           value="{{ $toDate ?? '' }}">
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-filter ml-1"></i> تصفية
                    </button>
                    <a href="{{ route('sitemanagement.reports.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times ml-1"></i> إلغاء
                    </a>
                </div>
                @if($fromDate || $toDate)
                <div class="mb-2 mr-2">
                    <span class="badge badge-info p-2" style="font-size:12px;">
                        <i class="fas fa-info-circle ml-1"></i>
                        النتائج مفلترة
                        @if($fromDate) من {{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }} @endif
                        @if($toDate) إلى {{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }} @endif
                    </span>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- ===== سكشن المستخدمين ===== --}}
    <div class="row mb-2">
        <div class="col-12">
            <h5 class="mt-2 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-users ml-2"></i> المستخدمين
            </h5>
        </div>
    </div>
    <div class="row">
        {{-- إجمالي المستخدمين --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.users.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #28a745 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">إجمالي المستخدمين</p>
                            <h2 class="font-weight-bold mb-0" style="color:#28a745;">{{ number_format($stats['users']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#28a745; opacity:.25;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- المستخدمين النشطين --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.users.index', ['filter_status' => 1]) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #17a2b8 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">المستخدمين النشطين</p>
                            <h2 class="font-weight-bold mb-0" style="color:#17a2b8;">{{ number_format($stats['users_active']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#17a2b8; opacity:.25;">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- المستخدمين غير النشطين --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.users.index', ['filter_status' => 0]) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #ffc107 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">المستخدمين غير النشطين</p>
                            <h2 class="font-weight-bold mb-0" style="color:#ffc107;">{{ number_format($stats['users_inactive']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#ffc107; opacity:.25;">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- المستخدمين المحظورين --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.users.index', ['filter_status' => 2]) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #dc3545 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">المستخدمين المحظورين</p>
                            <h2 class="font-weight-bold mb-0" style="color:#dc3545;">{{ number_format($stats['users_blocked']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#dc3545; opacity:.25;">
                            <i class="fas fa-user-slash"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- ===== سكشن العقارات ===== --}}
    <div class="row mb-2">
        <div class="col-12">
            <h5 class="mt-2 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-building ml-2"></i> العقارات
            </h5>
        </div>
    </div>
    <div class="row">
        {{-- إجمالي العقارات --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.aqars.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #007bff !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">إجمالي العقارات</p>
                            <h2 class="font-weight-bold mb-0" style="color:#007bff;">{{ number_format($stats['aqars']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#007bff; opacity:.25;">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- العقارات النشطة --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #28a745 !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:14px;">عقارات نشطة</p>
                        <h2 class="font-weight-bold mb-0" style="color:#28a745;">{{ number_format($stats['aqars_active']) }}</h2>
                    </div>
                    <div style="font-size:42px; color:#28a745; opacity:.25;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- عقارات في الانتظار --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #ffc107 !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:14px;">عقارات في الانتظار</p>
                        <h2 class="font-weight-bold mb-0" style="color:#ffc107;">{{ number_format($stats['aqars_pending']) }}</h2>
                    </div>
                    <div style="font-size:42px; color:#ffc107; opacity:.25;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- عقارات متوقفة --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #dc3545 !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:14px;">عقارات متوقفة</p>
                        <h2 class="font-weight-bold mb-0" style="color:#dc3545;">{{ number_format($stats['aqars_inactive']) }}</h2>
                    </div>
                    <div style="font-size:42px; color:#dc3545; opacity:.25;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- عقارات VIP --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #e83e8c !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:14px;">عقارات VIP</p>
                        <h2 class="font-weight-bold mb-0" style="color:#e83e8c;">{{ number_format($stats['aqars_vip']) }}</h2>
                    </div>
                    <div style="font-size:42px; color:#e83e8c; opacity:.25;">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== إحصائيات عامة ===== --}}
    <div class="row mb-2">
        <div class="col-12">
            <h5 class="mt-2 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-chart-bar ml-2"></i> إحصائيات عامة
            </h5>
        </div>
    </div>
    <div class="row">
        {{-- الشكاوى --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.complaints.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #dc3545 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد الشكاوى</p>
                            <h2 class="font-weight-bold mb-0" style="color:#dc3545;">{{ number_format($stats['complaints']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#dc3545; opacity:.25;">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض الشكاوى &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- الشركات --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.companies.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #fd7e14 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد الشركات</p>
                            <h2 class="font-weight-bold mb-0" style="color:#fd7e14;">{{ number_format($stats['companies']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#fd7e14; opacity:.25;">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض الشركات &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- نماذج الاتصال --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.contactForms.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #6f42c1 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">نماذج الاتصال</p>
                            <h2 class="font-weight-bold mb-0" style="color:#6f42c1;">{{ number_format($stats['contactForms']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#6f42c1; opacity:.25;">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض النماذج &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- المدونات --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.blogs.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #20c997 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد المدونات</p>
                            <h2 class="font-weight-bold mb-0" style="color:#20c997;">{{ number_format($stats['blogs']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#20c997; opacity:.25;">
                            <i class="fas fa-blog"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض المدونات &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- السلايدرات --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.sliders.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #17a2b8 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد السلايدرات</p>
                            <h2 class="font-weight-bold mb-0" style="color:#17a2b8;">{{ number_format($stats['sliders']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#17a2b8; opacity:.25;">
                            <i class="fas fa-images"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض السلايدرات &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- الإشعارات --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.notifications.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #6610f2 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد الإشعارات</p>
                            <h2 class="font-weight-bold mb-0" style="color:#6610f2;">{{ number_format($stats['notifications']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#6610f2; opacity:.25;">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض الإشعارات &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- طلبات التصوير --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.requestPhotoSessions.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #e83e8c !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">طلبات التصوير</p>
                            <h2 class="font-weight-bold mb-0" style="color:#e83e8c;">{{ number_format($stats['photoSessions']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#e83e8c; opacity:.25;">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض الطلبات &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- تواصل المستخدمين مع العقارات --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #795548 !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:14px;">تواصل مع العقارات</p>
                        <h2 class="font-weight-bold mb-0" style="color:#795548;">{{ number_format($stats['userContacts']) }}</h2>
                    </div>
                    <div style="font-size:42px; color:#795548; opacity:.25;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- اشتراكات الباقات --}}
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <a href="{{ route('sitemanagement.priceingSales.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #009688 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">اشتراكات الباقات</p>
                            <h2 class="font-weight-bold mb-0" style="color:#009688;">{{ number_format($stats['subscriptions']) }}</h2>
                        </div>
                        <div style="font-size:42px; color:#009688; opacity:.25;">
                            <i class="fas fa-gem"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض الباقات &rarr;</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- ===== عقارات حسب نوع العرض ===== --}}
    @if($aqarsByOfferType->count() > 0)
    <div class="row mb-2">
        <div class="col-12">
            <h5 class="mt-2 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-tags ml-2"></i> العقارات حسب نوع العرض
            </h5>
        </div>
    </div>
    <div class="row">
        @foreach($aqarsByOfferType as $offer)
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #007bff !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:14px;">{{ $offer->offer_name }}</p>
                        <h2 class="font-weight-bold mb-0" style="color:#007bff;">{{ number_format($offer->total) }}</h2>
                    </div>
                    <div style="font-size:42px; color:#007bff; opacity:.25;">
                        <i class="fas fa-tag"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ===== عقارات حسب المحافظة ===== --}}
    @if($aqarsByGovernrate->count() > 0)
    <div class="row mb-2">
        <div class="col-12">
            <h5 class="mt-2 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-map-marker-alt ml-2"></i> العقارات حسب المحافظة (أعلى 15)
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>المحافظة</th>
                                    <th style="width:150px;">عدد العقارات</th>
                                    <th style="width:200px;">النسبة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalGov = $aqarsByGovernrate->sum('total'); @endphp
                                @foreach($aqarsByGovernrate as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <i class="fas fa-map-pin text-primary ml-1"></i>
                                        <strong>{{ $item->gov_name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary p-2" style="font-size:14px;">{{ number_format($item->total) }}</span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height:20px;">
                                            @php $percent = $totalGov > 0 ? round(($item->total / $totalGov) * 100, 1) : 0; @endphp
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                 style="width: {{ $percent }}%;">
                                                {{ $percent }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== أنواع المستخدمين ===== --}}
    @if($userTypeStats->count() > 0)
    <div class="row mb-2">
        <div class="col-12">
            <h5 class="mt-2 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-user-tag ml-2"></i> المستخدمين حسب النوع
            </h5>
        </div>
    </div>
    <div class="row">
        @php
            $typeNames = [1 => 'مشتري او مستأجر', 2 => 'بائع او مؤجر', 3 => 'مطور عقاري', 4 => 'شركة'];
            $typeColors = [1 => '#17a2b8', 2 => '#28a745', 3 => '#fd7e14', 4 => '#6f42c1'];
            $typeIcons = [1 => 'fa-shopping-cart', 2 => 'fa-hand-holding-usd', 3 => 'fa-hard-hat', 4 => 'fa-building'];
        @endphp
        @foreach($userTypeStats as $typeStat)
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid {{ $typeColors[$typeStat->TYPE] ?? '#6c757d' }} !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:14px;">{{ $typeNames[$typeStat->TYPE] ?? 'غير محدد' }}</p>
                        <h2 class="font-weight-bold mb-0" style="color:{{ $typeColors[$typeStat->TYPE] ?? '#6c757d' }};">{{ number_format($typeStat->total) }}</h2>
                    </div>
                    <div style="font-size:42px; color:{{ $typeColors[$typeStat->TYPE] ?? '#6c757d' }}; opacity:.25;">
                        <i class="fas {{ $typeIcons[$typeStat->TYPE] ?? 'fa-user' }}"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ===== أكثر المستخدمين نشاطاً ===== --}}
    @if($topUsersByAqars->count() > 0)
    <div class="row mb-2">
        <div class="col-12">
            <h5 class="mt-2 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-trophy ml-2"></i> أكثر المستخدمين نشاطاً (عدد العقارات)
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>اسم المستخدم</th>
                                    <th>رقم الموبايل</th>
                                    <th style="width:150px;">عدد العقارات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topUsersByAqars as $index => $item)
                                <tr>
                                    <td>
                                        @if($index < 3)
                                            <span class="badge badge-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'dark') }} p-2">
                                                <i class="fas fa-trophy"></i> {{ $index + 1 }}
                                            </span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td><strong>{{ $item->name }}</strong></td>
                                    <td>{{ $item->MOP ?? '' }}</td>
                                    <td>
                                        <span class="badge badge-success p-2" style="font-size:14px;">{{ number_format($item->total) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== إحصائيات الدعوات ===== --}}
    <div class="row mb-2">
        <div class="col-12">
            <h5 class="mt-2 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-user-plus ml-2"></i> إحصائيات الدعوات (Invited By)
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    @if($invitedByStats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>الداعي (Invited By)</th>
                                    <th style="width:150px;">عدد المدعوين</th>
                                    <th style="width:200px;">النسبة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalInvited = $invitedByStats->sum('total'); @endphp
                                @foreach($invitedByStats as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <i class="fas fa-user text-primary ml-1"></i>
                                        <strong>{{ $item->invited_by }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info p-2" style="font-size:14px;">{{ number_format($item->total) }}</span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height:20px;">
                                            @php $percent = $totalInvited > 0 ? round(($item->total / $totalInvited) * 100, 1) : 0; @endphp
                                            <div class="progress-bar bg-success" role="progressbar"
                                                 style="width: {{ $percent }}%;">
                                                {{ $percent }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="2" class="font-weight-bold">الإجمالي</td>
                                    <td><span class="badge badge-dark p-2" style="font-size:14px;">{{ number_format($totalInvited) }}</span></td>
                                    <td><strong>100%</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>لا توجد بيانات دعوات حالياً</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
