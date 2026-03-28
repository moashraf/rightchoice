@extends('layouts.admin')

@section('title', 'تقارير المدفوعات')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">تقارير المدفوعات</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('sitemanagement.payments.index') }}">المدفوعات</a></li>
                    <li class="breadcrumb-item active">التقارير</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    {{-- Date Filter --}}
    <div class="card card-outline card-primary">
        <div class="card-body py-2">
            <form method="GET" class="form-inline">
                <label class="mr-2">من:</label>
                <input type="date" name="from" class="form-control form-control-sm mr-3" value="{{ $from }}">
                <label class="mr-2">إلى:</label>
                <input type="date" name="to" class="form-control form-control-sm mr-3" value="{{ $to }}">
                <button type="submit" class="btn btn-primary btn-sm mr-2"><i class="fas fa-filter"></i> تصفية</button>
                <a href="{{ route('sitemanagement.payments.reports') }}" class="btn btn-secondary btn-sm"><i class="fas fa-redo"></i></a>
            </form>
        </div>
    </div>

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
                    <h3>{{ number_format($stats['totalRevenue'], 2) }} <small>ج.م</small></h3>
                    <p>إجمالي الإيرادات</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['totalRefunded'], 2) }} <small>ج.م</small></h3>
                    <p>إجمالي المسترد</p>
                </div>
                <div class="icon"><i class="fas fa-undo"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($stats['netRevenue'], 2) }} <small>ج.م</small></h3>
                    <p>صافي الإيرادات</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Revenue Chart by Day --}}
        <div class="col-md-8">
            <div class="card card-outline card-success">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-area"></i> الإيرادات اليومية</h3></div>
                <div class="card-body">
                    <canvas id="revenueByDayChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>

        {{-- Payment Status Pie --}}
        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-pie"></i> توزيع الحالات</h3></div>
                <div class="card-body">
                    <canvas id="statusPieChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Payment Method Distribution --}}
        <div class="col-md-4">
            <div class="card card-outline card-primary">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-credit-card"></i> طرق الدفع</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped">
                        <thead><tr><th>الطريقة</th><th>العدد</th><th>المبلغ</th></tr></thead>
                        <tbody>
                        @foreach($methodDistribution as $method)
                            <tr>
                                <td>{{ $method['paymentMethod'] ?? '-' }}</td>
                                <td>{{ number_format($method['count']) }}</td>
                                <td>{{ number_format($method['total'], 2) }} ج.م</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Failed Transactions Report --}}
        <div class="col-md-4">
            <div class="card card-outline card-danger">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> المعاملات الفاشلة</h3></div>
                <div class="card-body">
                    <div class="d-flex justify-content-around mb-3">
                        <div class="text-center">
                            <h4 class="text-danger">{{ $failedReport['failedCount'] }}</h4>
                            <small>فاشلة</small>
                        </div>
                        <div class="text-center">
                            <h4>{{ $failedReport['failureRate'] }}%</h4>
                            <small>نسبة الفشل</small>
                        </div>
                    </div>
                    @if(count($failedReport['commonReasons']) > 0)
                        <h6>أسباب الفشل الشائعة:</h6>
                        <ul class="list-unstyled">
                            @foreach($failedReport['commonReasons'] as $reason)
                                <li><span class="badge badge-danger">{{ $reason['count'] }}</span> {{ $reason['failure_reason'] }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center">لا توجد أسباب مسجلة.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Refund Stats --}}
        <div class="col-md-4">
            <div class="card card-outline card-warning">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-undo"></i> إحصائيات الاسترداد</h3></div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">إجمالي الطلبات <span class="badge badge-info badge-pill">{{ $refundStats['total'] }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">قيد المراجعة <span class="badge badge-warning badge-pill">{{ $refundStats['pending'] }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">موافق عليها <span class="badge badge-primary badge-pill">{{ $refundStats['approved'] }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">مرفوضة <span class="badge badge-danger badge-pill">{{ $refundStats['rejected'] }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">تم الاسترداد <span class="badge badge-success badge-pill">{{ $refundStats['refunded'] }}</span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>إجمالي المبالغ</strong> <strong>{{ number_format($refundStats['totalAmount'], 2) }} ج.م</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Top Paying Users --}}
        <div class="col-md-6">
            <div class="card card-outline card-success">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-trophy"></i> أعلى المستخدمين دفعاً</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped">
                        <thead><tr><th>#</th><th>المستخدم</th><th>العدد</th><th>الإجمالي</th><th>آخر دفعة</th></tr></thead>
                        <tbody>
                        @foreach($topUsers as $i => $u)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    @if(isset($u['user']['name']))
                                        <a href="{{ route('sitemanagement.payments.userPayments', $u['user_id']) }}">{{ $u['user']['name'] }}</a>
                                    @else
                                        مستخدم #{{ $u['user_id'] }}
                                    @endif
                                </td>
                                <td>{{ $u['payment_count'] }}</td>
                                <td>{{ number_format($u['total_paid'], 2) }} ج.م</td>
                                <td>{{ $u['last_payment'] ? \Carbon\Carbon::parse($u['last_payment'])->format('Y-m-d') : '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-clock"></i> آخر المعاملات</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped">
                        <thead><tr><th>#</th><th>المستخدم</th><th>المبلغ</th><th>الحالة</th><th>التاريخ</th></tr></thead>
                        <tbody>
                        @foreach($recentTransactions as $t)
                            <tr>
                                <td><a href="{{ route('sitemanagement.payments.show', $t->id) }}">#{{ $t->id }}</a></td>
                                <td>{{ $t->user?->name ?? '-' }}</td>
                                <td>{{ number_format($t->paymentAmount, 2) }}</td>
                                <td><span class="badge badge-{{ $t->status_badge }}">{{ $t->status_label }}</span></td>
                                <td>{{ $t->created_at?->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue by Month --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-bar"></i> الإيرادات الشهرية</h3></div>
                <div class="card-body">
                    <canvas id="revenueByMonthChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue by Package --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-secondary">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-tags"></i> الإيرادات حسب الباقات</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped">
                        <thead><tr><th>الباقة</th><th>العدد</th><th>الإجمالي</th></tr></thead>
                        <tbody>
                        @foreach($revenueByPackage['pricing_sales'] ?? [] as $pkg)
                            <tr>
                                <td>{{ $pkg['pricing_sale']['type'] ?? 'باقة #' . $pkg['paqaat_priceing_sale_id'] }}</td>
                                <td>{{ $pkg['count'] }}</td>
                                <td>{{ number_format($pkg['total'], 2) }} ج.م</td>
                            </tr>
                        @endforeach
                        @if(empty($revenueByPackage['pricing_sales']))
                            <tr><td colspan="3" class="text-center text-muted">لا توجد بيانات</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline card-secondary">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-gem"></i> الإيرادات حسب VIP</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped">
                        <thead><tr><th>الباقة</th><th>العدد</th><th>الإجمالي</th></tr></thead>
                        <tbody>
                        @foreach($revenueByPackage['vip_packages'] ?? [] as $pkg)
                            <tr>
                                <td>{{ $pkg['price_vip']['name'] ?? 'VIP #' . $pkg['tmyezz_price_vip_id'] }}</td>
                                <td>{{ $pkg['count'] }}</td>
                                <td>{{ number_format($pkg['total'], 2) }} ج.م</td>
                            </tr>
                        @endforeach
                        @if(empty($revenueByPackage['vip_packages']))
                            <tr><td colspan="3" class="text-center text-muted">لا توجد بيانات</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('third_party_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue by Day Chart
    var dayData = @json($revenueByDay);
    new Chart(document.getElementById('revenueByDayChart'), {
        type: 'line',
        data: {
            labels: dayData.map(function(d) { return d.period; }),
            datasets: [
                { label: 'الإيرادات', data: dayData.map(function(d) { return d.revenue; }), borderColor: '#28a745', backgroundColor: 'rgba(40,167,69,0.1)', fill: true, tension: 0.3 },
                { label: 'المسترد', data: dayData.map(function(d) { return d.refunded; }), borderColor: '#ffc107', backgroundColor: 'rgba(255,193,7,0.1)', fill: true, tension: 0.3 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    // Status Pie Chart
    var statusData = @json($statusDistribution);
    var statusColors = { 'PAID': '#28a745', 'UNPAID': '#ffc107', 'PENDING': '#fd7e14', 'FAILED': '#dc3545', 'CANCELLED': '#6c757d', 'INITIATED': '#17a2b8', 'EXPIRED': '#343a40' };
    new Chart(document.getElementById('statusPieChart'), {
        type: 'doughnut',
        data: {
            labels: statusData.map(function(d) { return d.paymentStatus; }),
            datasets: [{ data: statusData.map(function(d) { return d.count; }), backgroundColor: statusData.map(function(d) { return statusColors[d.paymentStatus] || '#6c757d'; }) }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Revenue by Month Chart
    var monthData = @json($revenueByMonth);
    new Chart(document.getElementById('revenueByMonthChart'), {
        type: 'bar',
        data: {
            labels: monthData.map(function(d) { return d.period; }),
            datasets: [
                { label: 'الإيرادات', data: monthData.map(function(d) { return d.revenue; }), backgroundColor: '#28a745' },
                { label: 'المسترد', data: monthData.map(function(d) { return d.refunded; }), backgroundColor: '#ffc107' },
                { label: 'الرسوم', data: monthData.map(function(d) { return d.fees; }), backgroundColor: '#dc3545' }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });
});
</script>
@endsection
