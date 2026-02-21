@extends('layouts.app')
@section('title', 'لوحة التحكم')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mt-3 mb-4" style="font-weight:700; color:#343a40;">
                <i class="fas fa-tachometer-alt ml-2"></i> لوحة التحكم
            </h4>
        </div>
    </div>

    <div class="row">

        {{-- عدد العقارات --}}
        <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
            <a href="{{ url('aqars') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #007bff !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد العقارات</p>
                            <h2 class="font-weight-bold mb-0" style="color:#007bff;">{{ number_format($stats['aqars']) }}</h2>
                        </div>
                        <div style="font-size:48px; color:#007bff; opacity:.25;">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض جميع العقارات &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- عدد المستخدمين --}}
        <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
            <a href="{{ url('user') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #28a745 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد المستخدمين</p>
                            <h2 class="font-weight-bold mb-0" style="color:#28a745;">{{ number_format($stats['users']) }}</h2>
                        </div>
                        <div style="font-size:48px; color:#28a745; opacity:.25;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض جميع المستخدمين &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- عدد الشكاوي --}}
        <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
            <a href="{{ url('complaints') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #dc3545 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد الشكاوي</p>
                            <h2 class="font-weight-bold mb-0" style="color:#dc3545;">{{ number_format($stats['complaints']) }}</h2>
                        </div>
                        <div style="font-size:48px; color:#dc3545; opacity:.25;">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض جميع الشكاوي &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- عدد الشركات --}}
        <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
            <a href="{{ url('companys') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #fd7e14 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">عدد الشركات</p>
                            <h2 class="font-weight-bold mb-0" style="color:#fd7e14;">{{ number_format($stats['companies']) }}</h2>
                        </div>
                        <div style="font-size:48px; color:#fd7e14; opacity:.25;">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض جميع الشركات &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

        {{-- عدد نماذج الاتصال --}}
        <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
            <a href="{{ url('contactForms') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100" style="border-right: 5px solid #6f42c1 !important;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size:14px;">نماذج الاتصال</p>
                            <h2 class="font-weight-bold mb-0" style="color:#6f42c1;">{{ number_format($stats['contactForms']) }}</h2>
                        </div>
                        <div style="font-size:48px; color:#6f42c1; opacity:.25;">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">عرض جميع النماذج &rarr;</small>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
