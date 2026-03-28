<x-layout>

@section('title')
    مدفوعاتي
@endsection

<section id="profile-info" class="bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">

                <div class="col-md-8 mt-3">

                    {{-- Header --}}
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0">
                            <i class="fa fa-credit-card ml-2 text-primary"></i>
                            مدفوعاتي
                        </h3>
                        <a href="{{ URL::to(Config::get('app.locale').'/dashboard') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-right ml-1"></i> العودة للصفحة الشخصية
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

                    {{-- Summary Stats --}}
                    <div class="row mb-3">
                        <div class="col-6 col-md-4 mb-2">
                            <div class="card text-center shadow-sm">
                                <div class="card-body py-2">
                                    <h5 class="text-info mb-0">{{ $paymentCount ?? 0 }}</h5>
                                    <small class="text-muted">الإجمالي</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <div class="card text-center shadow-sm">
                                <div class="card-body py-2">
                                    <h5 class="text-success mb-0">{{ number_format($totalPaid ?? 0, 2) }}</h5>
                                    <small class="text-muted">إجمالي المدفوع</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <div class="card text-center shadow-sm">
                                <div class="card-body py-2">
                                    <h5 class="text-warning mb-0">{{ number_format($totalRefunded ?? 0, 2) }}</h5>
                                    <small class="text-muted">إجمالي المسترد</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Filter --}}
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body py-2">
                            <form method="GET" class="form-inline">
                                <label class="ml-2">الحالة:</label>
                                <select name="status" class="form-control form-control-sm ml-2" onchange="this.form.submit()">
                                    <option value="">الكل</option>
                                    @foreach(\App\Enums\PaymentStatusEnum::all() as $key => $val)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>

                    {{-- Payments List --}}
                    @forelse($payments as $payment)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h6 class="font-weight-bold mb-1">
                                            <i class="fa fa-receipt ml-1 text-primary"></i>
                                            {{ $payment->package_name }}
                                        </h6>
                                        <p class="mb-1 text-muted" style="font-size:13px;">
                                            <strong>المرجع:</strong> {{ $payment->referenceNumber ?? '-' }}
                                        </p>
                                        <p class="mb-1" style="font-size:13px;">
                                            <strong>المبلغ:</strong>
                                            <span class="text-success font-weight-bold">{{ number_format($payment->paymentAmount, 2) }} ج.م</span>
                                        </p>
                                        @if($payment->paymentMethod)
                                            <small class="text-muted">
                                                <i class="fa fa-credit-card ml-1"></i> {{ $payment->paymentMethod }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="col-md-3 text-center mt-2 mt-md-0">
                                        @php
                                            $badgeMap = ['success' => 'success', 'danger' => 'danger', 'warning' => 'warning', 'info' => 'info', 'secondary' => 'secondary', 'primary' => 'primary', 'dark' => 'dark'];
                                        @endphp
                                        <span class="badge badge-{{ $payment->status_badge }} p-2" style="font-size:13px;">
                                            {{ $payment->status_label }}
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fa fa-calendar ml-1"></i>
                                            {{ $payment->created_at ? $payment->created_at->format('Y-m-d') : '-' }}
                                        </small>
                                    </div>
                                    <div class="col-md-2 text-center mt-2 mt-md-0">
                                        <a href="{{ URL::to(Config::get('app.locale').'/user/payments/'.$payment->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-eye ml-1"></i> التفاصيل
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">لا توجد مدفوعات حتى الآن.</p>
                            </div>
                        </div>
                    @endforelse

                    {{-- Pagination --}}
                    @if($payments->hasPages())
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $payments->appends(request()->query())->links() }}
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
