<x-layout>

@section('title')
    تفاصيل الدفعة #{{ $payment->id }}
@endsection

<section id="profile-info" class="bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">

                <div class="col-md-8 mt-3">

                    {{-- Header --}}
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0">
                            <i class="fa fa-receipt ml-2 text-primary"></i>
                            تفاصيل الدفعة #{{ $payment->id }}
                        </h3>
                        <a href="{{ URL::to(Config::get('app.locale').'/user/payments') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-right ml-1"></i> العودة لقائمة المدفوعات
                        </a>
                    </div>

                    {{-- Flash Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle ml-1"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-times-circle ml-1"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    {{-- Payment Details Card --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-info-circle ml-1"></i> معلومات الدفعة
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="font-weight-bold" style="width:40%">الرقم المرجعي</td>
                                    <td><code>{{ $payment->referenceNumber ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">المبلغ</td>
                                    <td><span class="text-success font-weight-bold">{{ number_format($payment->paymentAmount, 2) }} ج.م</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">الحالة</td>
                                    <td>
                                        <span class="badge badge-{{ $payment->status_badge }} p-2">{{ $payment->status_label }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">طريقة الدفع</td>
                                    <td>{{ $payment->paymentMethod ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">الباقة</td>
                                    <td>{{ $payment->package_name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">تاريخ الإنشاء</td>
                                    <td>{{ $payment->created_at ? $payment->created_at->format('Y-m-d H:i') : '-' }}</td>
                                </tr>
                                @if($payment->paid_at)
                                <tr>
                                    <td class="font-weight-bold">تاريخ الدفع</td>
                                    <td>{{ $payment->paid_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                @endif
                                @if($payment->failure_reason)
                                <tr>
                                    <td class="font-weight-bold">سبب الفشل</td>
                                    <td class="text-danger">{{ $payment->failure_reason }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    {{-- Refund Status --}}
                    @if($payment->refunds && $payment->refunds->count() > 0)
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-warning text-dark">
                                <i class="fa fa-undo ml-1"></i> طلبات الاسترداد
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>المبلغ</th>
                                            <th>الحالة</th>
                                            <th>السبب</th>
                                            <th>التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payment->refunds as $refund)
                                        <tr>
                                            <td>{{ number_format($refund->refund_amount, 2) }} ج.م</td>
                                            <td><span class="badge badge-{{ $refund->status_badge }}">{{ $refund->status_label }}</span></td>
                                            <td>{{ \Illuminate\Support\Str::limit($refund->refund_reason, 50) }}</td>
                                            <td>{{ $refund->created_at?->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Request Refund Form --}}
                    @if($payment->isPaid() && $payment->canRefund())
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-info text-white">
                                <i class="fa fa-undo ml-1"></i> طلب استرداد
                            </div>
                            <div class="card-body">
                                <form action="{{ URL::to(Config::get('app.locale').'/user/payments/'.$payment->id.'/refund') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>المبلغ المطلوب استرداده</label>
                                        <input type="number" name="refund_amount" class="form-control"
                                               step="0.01" min="0.01"
                                               max="{{ $payment->getRefundableAmount() }}"
                                               value="{{ $payment->getRefundableAmount() }}" required>
                                        <small class="text-muted">الحد الأقصى: {{ number_format($payment->getRefundableAmount(), 2) }} ج.م</small>
                                        @error('refund_amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>سبب طلب الاسترداد</label>
                                        <textarea name="refund_reason" class="form-control" rows="3"
                                                  placeholder="يرجى توضيح سبب طلب الاسترداد..." required></textarea>
                                        @error('refund_reason')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-warning"
                                            onclick="return confirm('هل أنت متأكد من طلب الاسترداد؟')">
                                        <i class="fa fa-undo ml-1"></i> إرسال طلب الاسترداد
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- Status Timeline --}}
                    @if($payment->statusLogs && $payment->statusLogs->count() > 0)
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-secondary text-white">
                                <i class="fa fa-history ml-1"></i> سجل الحالات
                            </div>
                            <div class="card-body">
                                @foreach($payment->statusLogs->sortByDesc('created_at') as $log)
                                    <div class="d-flex mb-2 pb-2 border-bottom">
                                        <div class="ml-3">
                                            <i class="fa fa-circle text-{{ $log->new_status == 'PAID' ? 'success' : ($log->new_status == 'FAILED' ? 'danger' : 'info') }}" style="font-size:10px;"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $log->event_type }}</strong>
                                            @if($log->old_status || $log->new_status)
                                                <span class="text-muted">
                                                    ({{ $log->old_status ?? '-' }} → {{ $log->new_status ?? '-' }})
                                                </span>
                                            @endif
                                            @if($log->message)
                                                <br><small class="text-muted">{{ $log->message }}</small>
                                            @endif
                                            <br><small class="text-muted">{{ $log->created_at?->format('Y-m-d H:i') }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                @include('components.profile-sidebar')

            </div>
        </div>
    </div>
</section>

<x-call-to-action/>

</x-layout>
