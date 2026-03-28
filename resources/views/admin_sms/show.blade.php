{{-- SMS Batch Details Page --}}
@extends('layouts.admin')

@section('title', 'تفاصيل دفعة SMS #' . $batch->id)

@section('third_party_stylesheets')
    @include('layouts.datatables_css')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-info-circle"></i> تفاصيل الدفعة #{{ $batch->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('sitemanagement.sms.index') }}" class="btn btn-default float-right">
                        <i class="fas fa-arrow-right"></i> العودة للتقارير
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        {{-- Batch Info Card --}}
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-file-alt"></i> معلومات الدفعة</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="font-weight-bold" width="40%">رقم الدفعة:</td>
                                <td>#{{ $batch->id }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">بواسطة:</td>
                                <td>{{ $batch->createdBy ? $batch->createdBy->name : '—' }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">نوع الإرسال:</td>
                                <td>{{ $batch->send_type_label }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">مزود الخدمة:</td>
                                <td>{{ $batch->provider_name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">تاريخ الإنشاء:</td>
                                <td>{{ $batch->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">الحالة العامة:</td>
                                <td>
                                    <span class="badge {{ $batch->overall_status_badge }}">
                                        {{ $batch->overall_status_label }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">نص الرسالة (القالب):</label>
                            <div class="p-3 bg-light border rounded" dir="rtl" style="min-height: 80px;">
                                {{ $batch->message_template }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row">
            <div class="col-lg-2 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats['total'] }}</h3>
                        <p>إجمالي المستلمين</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $stats['valid'] }}</h3>
                        <p>أرقام صالحة</p>
                    </div>
                    <div class="icon"><i class="fas fa-phone"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats['sent'] }}</h3>
                        <p>تم الإرسال</p>
                    </div>
                    <div class="icon"><i class="fas fa-check"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ $stats['delivered'] }}</h3>
                        <p>تم التسليم</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-double"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $stats['failed'] }}</h3>
                        <p>فشل</p>
                    </div>
                    <div class="icon"><i class="fas fa-times"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['invalid'] }}</h3>
                        <p>رقم غير صالح</p>
                    </div>
                    <div class="icon"><i class="fas fa-phone-slash"></i></div>
                </div>
            </div>
        </div>

        {{-- Retry Failed Button --}}
        @if($stats['failed'] > 0 && auth()->guard('admin')->user()->hasPermission('sms.send'))
            <div class="mb-3">
                <form action="{{ route('sitemanagement.sms.retry', $batch->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('هل أنت متأكد من إعادة إرسال الرسائل الفاشلة؟')">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-redo"></i> إعادة إرسال الرسائل الفاشلة ({{ $stats['failed'] }})
                    </button>
                </form>
            </div>
        @endif

        {{-- Pending indicator --}}
        @if($stats['pending'] > 0)
            <div class="alert alert-info">
                <i class="fas fa-spinner fa-spin"></i>
                يوجد <strong>{{ $stats['pending'] }}</strong> رسالة قيد المعالجة. يمكنك تحديث الصفحة لمتابعة التقدم.
                <a href="{{ route('sitemanagement.sms.show', $batch->id) }}" class="btn btn-sm btn-info mr-2">
                    <i class="fas fa-sync-alt"></i> تحديث
                </a>
            </div>
        @endif

        {{-- Recipients DataTable --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list"></i> تفاصيل المستلمين</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive p-3">
                    {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered table-sm']) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    @include('layouts.datatables_js')
@endsection
