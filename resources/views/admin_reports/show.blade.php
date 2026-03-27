{{-- Chat Report Details --}}
@extends('layouts.admin')

@section('title', 'تفاصيل التبليغ')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-flag"></i> تفاصيل التبليغ</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('sitemanagement.chatReports.index') }}" class="btn btn-outline-secondary float-right">
                        <i class="fas fa-arrow-right"></i> العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="row">
            {{-- Report Info --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">معلومات التبليغ</h3>
                        <span class="badge badge-{{ $report->getStatusBadge() }} float-right">{{ $report->getStatusLabel() }}</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width:150px">المبلّغ</th>
                                <td>{{ $report->reporter ? $report->reporter->name : 'محذوف' }}
                                    @if($report->reporter)
                                        <small class="text-muted">({{ $report->reporter->email }})</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>المبلّغ عنه</th>
                                <td>{{ $report->reported ? $report->reported->name : 'محذوف' }}
                                    @if($report->reported)
                                        <small class="text-muted">({{ $report->reported->email }})</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>النوع</th>
                                <td>
                                    @php
                                        $types = ['user' => 'مستخدم', 'message' => 'رسالة', 'post' => 'منشور', 'comment' => 'تعليق'];
                                    @endphp
                                    {{ $types[$report->reported_type] ?? $report->reported_type }}
                                </td>
                            </tr>
                            <tr>
                                <th>السبب</th>
                                <td>
                                    @php
                                        $reasons = ['spam' => 'سبام', 'harassment' => 'تحرش', 'inappropriate' => 'محتوى غير لائق', 'fake' => 'حساب مزيف', 'other' => 'أخرى'];
                                    @endphp
                                    <span class="badge badge-danger">{{ $reasons[$report->reason] ?? $report->reason }}</span>
                                </td>
                            </tr>
                            @if($report->details)
                                <tr>
                                    <th>التفاصيل</th>
                                    <td>{{ $report->details }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>التاريخ</th>
                                <td>{{ $report->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @if($report->reviewed_at)
                                <tr>
                                    <th>تاريخ المراجعة</th>
                                    <td>{{ $report->reviewed_at }}</td>
                                </tr>
                                <tr>
                                    <th>المراجع</th>
                                    <td>{{ isset($report->reviewer) ? $report->reviewer->name : '-' }}</td>
                                </tr>
                            @endif
                            @if($report->admin_notes)
                                <tr>
                                    <th>ملاحظات الإدارة</th>
                                    <td>{{ $report->admin_notes }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="col-md-4">
                @if($report->status === 'pending')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">اتخاذ إجراء</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sitemanagement.chatReports.review', $report->_id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>القرار</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">اختر...</option>
                                        <option value="reviewed">قبول البلاغ</option>
                                        <option value="dismissed">رفض البلاغ</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>ملاحظات</label>
                                    <textarea name="admin_notes" class="form-control" rows="3" placeholder="ملاحظات اختيارية..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">حفظ القرار</button>
                            </form>

                            <hr>
                            <form action="{{ route('sitemanagement.chatReports.blockUser', $report->_id) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من حظر هذا المستخدم؟')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-ban"></i> حظر المستخدم المبلّغ عنه
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
