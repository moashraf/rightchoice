{{-- Chat Reports Management --}}
@extends('layouts.admin')

@section('title', 'إدارة تبليغات المحادثات')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-flag"></i> إدارة تبليغات المحادثات</h1>
                </div>
                <div class="col-sm-6">
                    <span class="badge badge-warning float-right" style="font-size:16px">
                        {{ $pendingCount }} تبليغ معلق
                    </span>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        {{-- Filter tabs --}}
        <div class="mb-3">
            <a href="{{ route('sitemanagement.chatReports.index', ['status' => 'all']) }}"
               class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">الكل</a>
            <a href="{{ route('sitemanagement.chatReports.index', ['status' => 'pending']) }}"
               class="btn btn-sm {{ $status === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">معلق</a>
            <a href="{{ route('sitemanagement.chatReports.index', ['status' => 'reviewed']) }}"
               class="btn btn-sm {{ $status === 'reviewed' ? 'btn-success' : 'btn-outline-success' }}">تمت المراجعة</a>
            <a href="{{ route('sitemanagement.chatReports.index', ['status' => 'dismissed']) }}"
               class="btn btn-sm {{ $status === 'dismissed' ? 'btn-secondary' : 'btn-outline-secondary' }}">مرفوض</a>
        </div>

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>المبلّغ</th>
                            <th>المبلّغ عنه</th>
                            <th>النوع</th>
                            <th>السبب</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $report->reporter ? $report->reporter->name : 'محذوف' }}</td>
                                <td>{{ $report->reported ? $report->reported->name : 'محذوف' }}</td>
                                <td>
                                    @php
                                        $types = ['user' => 'مستخدم', 'message' => 'رسالة', 'post' => 'منشور', 'comment' => 'تعليق'];
                                    @endphp
                                    {{ $types[$report->reported_type] ?? $report->reported_type }}
                                </td>
                                <td>
                                    @php
                                        $reasons = ['spam' => 'سبام', 'harassment' => 'تحرش', 'inappropriate' => 'محتوى غير لائق', 'fake' => 'حساب مزيف', 'other' => 'أخرى'];
                                    @endphp
                                    {{ $reasons[$report->reason] ?? $report->reason }}
                                </td>
                                <td><span class="badge badge-{{ $report->getStatusBadge() }}">{{ $report->getStatusLabel() }}</span></td>
                                <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('sitemanagement.chatReports.show', $report->_id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">لا توجد تبليغات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($reports->hasPages())
                <div class="card-footer">
                    {{ $reports->appends(['status' => $status])->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
