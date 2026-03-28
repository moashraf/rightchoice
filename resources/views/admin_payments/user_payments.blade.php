@extends('layouts.admin')

@section('title', 'مدفوعات المستخدم: ' . $user->name)

@php
    $__au = \Illuminate\Support\Facades\Auth::guard('admin')->check()
        ? \Illuminate\Support\Facades\Auth::guard('admin')->user()
        : \Illuminate\Support\Facades\Auth::user();

    $canView    = $__au && $__au->hasPermission('payments.view');
    $canManage  = $__au && $__au->hasPermission('payments.manage');
@endphp

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">مدفوعات: {{ $user->name }}</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('sitemanagement.payments.index') }}">المدفوعات</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    {{-- User Info --}}
    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong><i class="fas fa-user mr-1"></i> الاسم:</strong>
                    <p>{{ $user->name }}</p>
                </div>
                <div class="col-md-3">
                    <strong><i class="fas fa-envelope mr-1"></i> البريد:</strong>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="col-md-3">
                    <strong><i class="fas fa-phone mr-1"></i> الهاتف:</strong>
                    <p>{{ $user->phone ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <strong><i class="fas fa-calendar mr-1"></i> تاريخ التسجيل:</strong>
                    <p>{{ $user->created_at?->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $summary['total_count'] ?? 0 }}</h3>
                    <p>إجمالي المعاملات</p>
                </div>
                <div class="icon"><i class="fas fa-receipt"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($summary['total_paid'] ?? 0, 2) }} <small>ج.م</small></h3>
                    <p>إجمالي المدفوع</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($summary['total_refunded'] ?? 0, 2) }} <small>ج.م</small></h3>
                    <p>إجمالي المسترد</p>
                </div>
                <div class="icon"><i class="fas fa-undo"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $summary['success_count'] ?? 0 }}</h3>
                    <p>معاملات ناجحة</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
    </div>

    {{-- Payments Table --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> سجل المدفوعات</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الرقم المرجعي</th>
                        <th>المبلغ</th>
                        <th>الحالة</th>
                        <th>طريقة الدفع</th>
                        <th>الباقة</th>
                        <th>تاريخ الدفع</th>
                        <th>تاريخ الإنشاء</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td><code>{{ $payment->referenceNumber ?? '-' }}</code></td>
                        <td>{{ number_format($payment->paymentAmount, 2) }} ج.م</td>
                        <td><span class="badge badge-{{ $payment->status_badge }}">{{ $payment->status_label }}</span></td>
                        <td>{{ $payment->paymentMethod ?? '-' }}</td>
                        <td>{{ $payment->package_name }}</td>
                        <td>{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ $payment->created_at?->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($canView)
                            <a href="{{ route('sitemanagement.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">لا توجد مدفوعات لهذا المستخدم.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
        <div class="card-footer clearfix">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
