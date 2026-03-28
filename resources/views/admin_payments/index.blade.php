@extends('layouts.admin')

@section('title', 'إدارة المدفوعات')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">إدارة المدفوعات</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/sitemanagement/blogs') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item active">المدفوعات</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    {{-- Summary Cards --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['totalCount']) }}</h3>
                    <p>إجمالي المعاملات</p>
                </div>
                <div class="icon"><i class="fas fa-receipt"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['totalRevenue'], 2) }}</h3>
                    <p>إجمالي الإيرادات (ج.م)</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['totalRefunded'], 2) }}</h3>
                    <p>إجمالي المسترد (ج.م)</p>
                </div>
                <div class="icon"><i class="fas fa-undo"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($stats['netRevenue'], 2) }}</h3>
                    <p>صافي الإيرادات (ج.م)</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>
    </div>

    {{-- Quick Stats Row --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ناجحة</span>
                    <span class="info-box-number">{{ number_format($stats['successCount']) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">فاشلة</span>
                    <span class="info-box-number">{{ number_format($stats['failedCount']) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">معلقة</span>
                    <span class="info-box-number">{{ number_format($stats['pendingCount']) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card card-outline card-primary collapsed-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter"></i> فلاتر البحث</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form id="filter-form" method="GET">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>حالة الدفع</label>
                            <select name="filter_status" class="form-control form-control-sm">
                                <option value="">الكل</option>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ request('filter_status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>طريقة الدفع</label>
                            <select name="filter_method" class="form-control form-control-sm">
                                <option value="">الكل</option>
                                <option value="PAYATFAWRY" {{ request('filter_method') == 'PAYATFAWRY' ? 'selected' : '' }}>فوري</option>
                                <option value="CARD" {{ request('filter_method') == 'CARD' ? 'selected' : '' }}>بطاقة</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>حالة الاسترداد</label>
                            <select name="filter_refund_status" class="form-control form-control-sm">
                                <option value="">الكل</option>
                                @foreach($refundStatuses as $key => $label)
                                    <option value="{{ $key }}" {{ request('filter_refund_status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>من تاريخ</label>
                            <input type="date" name="filter_date_from" class="form-control form-control-sm" value="{{ request('filter_date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>إلى تاريخ</label>
                            <input type="date" name="filter_date_to" class="form-control form-control-sm" value="{{ request('filter_date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>رقم المرجع</label>
                            <input type="text" name="filter_reference" class="form-control form-control-sm" value="{{ request('filter_reference') }}" placeholder="رقم المرجع...">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> بحث</button>
                <a href="{{ route('sitemanagement.payments.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-redo"></i> إعادة تعيين</a>
            </form>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> قائمة المدفوعات</h3>
            <div class="card-tools">
                <a href="{{ route('sitemanagement.payments.reports') }}" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-chart-bar"></i> التقارير
                </a>
                <a href="{{ route('sitemanagement.payments.refunds') }}" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-undo"></i> المستردات
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('flash::message')
            {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-striped table-sm']) !!}
        </div>
    </div>
</div>
@endsection

@section('third_party_scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endsection
