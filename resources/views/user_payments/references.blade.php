<x-layout>

@section('title')
    أرقام الدفع المرجعية
@endsection

<section id="profile-info" class="bg-light" style="min-height:80vh;">
    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-8 mt-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <h3 class="mb-2">
                            <i class="fa fa-list-ol ml-2 text-info"></i>
                            كل أرقام الدفع المرجعية
                        </h3>
                        <a href="{{ URL::to(Config::get('app.locale').'/user_point_count_history') }}"
                           class="btn btn-secondary btn-sm mb-2">
                            <i class="fa fa-arrow-right ml-1"></i> العودة إلى باقاتي
                        </a>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="card text-center shadow-sm border-success">
                                <div class="card-body py-2">
                                    <strong class="text-success">{{ $paidCount }}</strong>
                                    <div class="small text-muted">عمليات مدفوعة</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card text-center shadow-sm border-warning">
                                <div class="card-body py-2">
                                    <strong class="text-warning">{{ $unpaidCount }}</strong>
                                    <div class="small text-muted">عمليات غير مدفوعة</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <i class="fa fa-credit-card ml-1"></i>
                            العمليات المدفوعة وغير المدفوعة
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0 text-right">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الرقم المرجعي</th>
                                            <th>مرجع التاجر</th>
                                            <th>الباقة</th>
                                            <th>المبلغ</th>
                                            <th>الحالة</th>
                                            <th>التاريخ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>
                                                <code>{{ $payment->referenceNumber ?: '-' }}</code>
                                                <small class="d-block text-muted">{{ $payment->paymentMethod ?: '-' }}</small>
                                            </td>
                                            <td><code>{{ $payment->merchantRefNumber ?: '-' }}</code></td>
                                            <td>{{ $payment->package_name }}</td>
                                            <td>{{ number_format($payment->paymentAmount, 2) }} ج.م</td>
                                            <td>
                                                <span class="badge badge-{{ $payment->status_badge }} p-2">
                                                    {{ $payment->status_label }}
                                                </span>
                                            </td>
                                            <td>{{ $payment->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
                                            <td>
                                                <a href="{{ URL::to(Config::get('app.locale').'/my-payments/'.$payment->id) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="عرض كل التفاصيل">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-5">
                                                <i class="fa fa-inbox fa-2x d-block mb-2"></i>
                                                لا توجد أرقام دفع مرجعية حتى الآن.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($payments->hasPages())
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $payments->links() }}
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
