@extends('layouts.admin')

@section('title', 'تفاصيل الدفعة #' . $payment->id)

@php
    $__au = \Illuminate\Support\Facades\Auth::guard('admin')->check()
        ? \Illuminate\Support\Facades\Auth::guard('admin')->user()
        : \Illuminate\Support\Facades\Auth::user();

    $canView    = $__au && $__au->hasPermission('payments.view');
    $canManage  = $__au && $__au->hasPermission('payments.manage');
    $canRefunds = $__au && $__au->hasPermission('payments.refunds');
@endphp

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">تفاصيل الدفعة #{{ $payment->id }}</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('sitemanagement.payments.index') }}">المدفوعات</a></li>
                    <li class="breadcrumb-item active">#{{ $payment->id }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @include('flash::message')

    <div class="row">
        {{-- Payment Info --}}
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-info-circle"></i> معلومات الدفعة</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <tr><th style="width:30%">رقم الدفعة</th><td>#{{ $payment->id }}</td></tr>
                        <tr><th>المستخدم</th><td>
                            @if($payment->user)
                                <a href="{{ route('sitemanagement.payments.userPayments', $payment->user_id) }}">{{ $payment->user->name }}</a>
                                <br><small class="text-muted">{{ $payment->user->email }}</small>
                            @else
                                مستخدم #{{ $payment->user_id }}
                            @endif
                        </td></tr>
                        <tr><th>المبلغ</th><td><strong class="text-success">{{ number_format($payment->paymentAmount, 2) }} {{ $payment->currency ?? 'ج.م' }}</strong></td></tr>
                        <tr><th>حالة الدفع</th><td><span class="badge badge-{{ $payment->status_badge }}">{{ $payment->status_label }}</span></td></tr>
                        <tr><th>طريقة الدفع</th><td>{{ $payment->paymentMethod }}</td></tr>
                        <tr><th>نوع المعاملة</th><td>{{ $payment->transaction_type ?? 'purchase' }}</td></tr>
                        <tr><th>رقم المرجع (فوري)</th><td><code>{{ $payment->referenceNumber }}</code></td></tr>
                        <tr><th>رقم مرجع التاجر</th><td><code>{{ $payment->merchantRefNumber }}</code></td></tr>
                        <tr><th>الباقة</th><td>{{ $payment->package_name }}</td></tr>
                        <tr><th>رسوم البوابة</th><td>{{ number_format($payment->gateway_fees, 2) }} ج.م</td></tr>
                        <tr><th>صافي المبلغ</th><td>{{ number_format($payment->net_amount, 2) }} ج.م</td></tr>
                        <tr><th>تاريخ الإنشاء</th><td>{{ $payment->created_at?->format('Y-m-d H:i:s') }}</td></tr>
                        <tr><th>تاريخ الدفع</th><td>{{ $payment->paid_at?->format('Y-m-d H:i:s') ?? '-' }}</td></tr>
                        @if($payment->failure_reason)
                        <tr><th>سبب الفشل</th><td class="text-danger">{{ $payment->failure_reason }}</td></tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Refund Info --}}
            @if($payment->refund_status || $payment->refunds->count() > 0)
            <div class="card card-warning card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-undo"></i> معلومات الاسترداد</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <tr><th style="width:30%">حالة الاسترداد</th><td>
                            @if($payment->refund_status)
                                <span class="badge badge-{{ $payment->refund_status_badge }}">{{ $payment->refund_status_label }}</span>
                            @else - @endif
                        </td></tr>
                        <tr><th>إجمالي المسترد</th><td>{{ number_format($payment->refunded_amount, 2) }} ج.م</td></tr>
                        <tr><th>قابل للاسترداد</th><td>{{ number_format($payment->getRefundableAmount(), 2) }} ج.م</td></tr>
                    </table>

                    @if($payment->refunds->count() > 0)
                    <div class="p-3">
                        <h6>طلبات الاسترداد:</h6>
                        <table class="table table-sm table-bordered">
                            <thead><tr><th>#</th><th>المبلغ</th><th>الحالة</th><th>السبب</th><th>المشرف</th><th>التاريخ</th></tr></thead>
                            <tbody>
                            @foreach($payment->refunds as $refund)
                                <tr>
                                    <td>{{ $refund->id }}</td>
                                    <td>{{ number_format($refund->refund_amount, 2) }} ج.م</td>
                                    <td><span class="badge badge-{{ $refund->status_badge }}">{{ $refund->status_label }}</span></td>
                                    <td>{{ $refund->refund_reason ?? '-' }}</td>
                                    <td>{{ $refund->admin?->name ?? '-' }}</td>
                                    <td>{{ $refund->created_at?->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Status History --}}
            <div class="card card-info card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-history"></i> سجل الحالة</h3></div>
                <div class="card-body p-0">
                    @if($payment->statusLogs->count() > 0)
                    <div class="timeline timeline-inverse p-3">
                        @foreach($payment->statusLogs->sortByDesc('created_at') as $log)
                        <div>
                            <i class="fas fa-circle bg-{{ $log->event_type === 'refund' ? 'warning' : 'info' }}"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> {{ $log->created_at?->format('Y-m-d H:i') }}</span>
                                <h3 class="timeline-header">
                                    {{ $log->event_type }}
                                    @if($log->old_status) <span class="badge badge-secondary">{{ $log->old_status }}</span> @endif
                                    @if($log->old_status && $log->new_status) → @endif
                                    @if($log->new_status) <span class="badge badge-primary">{{ $log->new_status }}</span> @endif
                                </h3>
                                @if($log->message)<div class="timeline-body">{{ $log->message }}</div>@endif
                                @if($log->performer)<div class="timeline-footer"><small>بواسطة: {{ $log->performer->name }}</small></div>@endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <div class="p-3 text-muted text-center">لا يوجد سجل حالة بعد.</div>
                    @endif
                </div>
            </div>

            {{-- Gateway Raw Data --}}
            @if($payment->gateway_response || $payment->callback_payload)
            <div class="card card-secondary card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-code"></i> بيانات البوابة الخام</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @if($payment->gateway_response)
                        <h6>Gateway Response:</h6>
                        <pre class="bg-dark text-light p-2 rounded" style="max-height:200px;overflow:auto;">{{ $payment->gateway_response }}</pre>
                    @endif
                    @if($payment->callback_payload)
                        <h6>Callback Payload:</h6>
                        <pre class="bg-dark text-light p-2 rounded" style="max-height:200px;overflow:auto;">{{ $payment->callback_payload }}</pre>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar Actions --}}
        <div class="col-md-4">
            {{-- Update Status --}}
            @if($canManage)
            <div class="card card-outline card-success">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-edit"></i> تحديث الحالة</h3></div>
                <div class="card-body">
                    <form action="{{ route('sitemanagement.payments.updateStatus', $payment->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>الحالة الجديدة</label>
                            <select name="status" class="form-control form-control-sm" required>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ $payment->paymentStatus == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ملاحظة (اختياري)</label>
                            <textarea name="message" class="form-control form-control-sm" rows="2" maxlength="500"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm btn-block" onclick="return confirm('هل أنت متأكد من تحديث الحالة؟')">
                            <i class="fas fa-save"></i> تحديث الحالة
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Initiate Refund --}}
            @if($canRefunds && $payment->canRefund())
            <div class="card card-outline card-warning">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-undo"></i> طلب استرداد</h3></div>
                <div class="card-body">
                    <form action="{{ route('sitemanagement.payments.initiateRefund', $payment->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>مبلغ الاسترداد (الحد الأقصى: {{ number_format($payment->getRefundableAmount(), 2) }} ج.م)</label>
                            <input type="number" name="refund_amount" class="form-control form-control-sm" step="0.01" min="0.01" max="{{ $payment->getRefundableAmount() }}" required>
                        </div>
                        <div class="form-group">
                            <label>سبب الاسترداد</label>
                            <textarea name="refund_reason" class="form-control form-control-sm" rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-sm btn-block" onclick="return confirm('هل أنت متأكد من إنشاء طلب الاسترداد؟')">
                            <i class="fas fa-undo"></i> إنشاء طلب استرداد
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Add Note --}}
            @if($canManage)
            <div class="card card-outline card-info">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-sticky-note"></i> إضافة ملاحظة</h3></div>
                <div class="card-body">
                    <form action="{{ route('sitemanagement.payments.addNote', $payment->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="note" class="form-control form-control-sm" rows="3" placeholder="اكتب ملاحظة..." required maxlength="2000"></textarea>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm btn-block">
                            <i class="fas fa-plus"></i> إضافة ملاحظة
                        </button>
                    </form>

                    @if($payment->notes->count() > 0)
                    <hr>
                    @foreach($payment->notes->sortByDesc('created_at') as $note)
                        <div class="callout callout-info py-2 px-3">
                            <small class="text-muted">{{ $note->admin?->name ?? 'مشرف' }} - {{ $note->created_at?->format('Y-m-d H:i') }}</small>
                            <p class="mb-0">{{ $note->note }}</p>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @else
            {{-- Show notes read-only for viewers --}}
            @if($payment->notes->count() > 0)
            <div class="card card-outline card-info">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-sticky-note"></i> الملاحظات</h3></div>
                <div class="card-body">
                    @foreach($payment->notes->sortByDesc('created_at') as $note)
                        <div class="callout callout-info py-2 px-3">
                            <small class="text-muted">{{ $note->admin?->name ?? 'مشرف' }} - {{ $note->created_at?->format('Y-m-d H:i') }}</small>
                            <p class="mb-0">{{ $note->note }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            {{-- Quick Links --}}
            <div class="card">
                <div class="card-body p-2">
                    <a href="{{ route('sitemanagement.payments.index') }}" class="btn btn-secondary btn-sm btn-block">
                        <i class="fas fa-arrow-right"></i> العودة للقائمة
                    </a>
                    @if($payment->user)
                    <a href="{{ route('sitemanagement.payments.userPayments', $payment->user_id) }}" class="btn btn-outline-primary btn-sm btn-block">
                        <i class="fas fa-user"></i> مدفوعات المستخدم
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
