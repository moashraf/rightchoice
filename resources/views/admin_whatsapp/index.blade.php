{{-- WhatsApp Reports / History Page --}}
@extends('layouts.admin')

@section('title', 'تقارير رسائل واتساب')

@section('third_party_stylesheets')
    @include('layouts.datatables_css')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fab fa-whatsapp"></i> تقارير رسائل واتساب</h1>
                </div>
                <div class="col-sm-6">
                    @if(auth()->guard('admin')->user()->hasPermission('whatsapp.send'))
                    <a href="{{ route('sitemanagement.whatsapp.create') }}" class="btn btn-success float-right">
                        <i class="fab fa-whatsapp"></i> إرسال رسائل جديدة
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        {{-- Summary Cards --}}
        @php
            $totalBatches   = \App\Models\WhatsappBatch::count();
            $totalSent      = \App\Models\WhatsappBatch::sum('total_sent');
            $totalFailed    = \App\Models\WhatsappBatch::sum('total_failed');
            $totalInvalid   = \App\Models\WhatsappBatch::sum('total_invalid_numbers');
        @endphp
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalBatches }}</h3>
                        <p>إجمالي الدفعات</p>
                    </div>
                    <div class="icon"><i class="fab fa-whatsapp"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalSent }}</h3>
                        <p>تم إرسالها</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalFailed }}</h3>
                        <p>فشل الإرسال</p>
                    </div>
                    <div class="icon"><i class="fas fa-times-circle"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalInvalid }}</h3>
                        <p>أرقام غير صالحة</p>
                    </div>
                    <div class="icon"><i class="fas fa-phone-slash"></i></div>
                </div>
            </div>
        </div>

        {{-- DataTable --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">سجل جميع الدفعات</h3>
            </div>
            <div class="card-body p-0">
                @include('admin_whatsapp.table')
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    @include('layouts.datatables_js')
@endsection
