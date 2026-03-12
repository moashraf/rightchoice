@extends('layouts.admin')
@section('title', 'تفاصيل المدعوين')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
            <h4 class="mt-3 mb-3" style="font-weight:700; color:#343a40;">
                <i class="fas fa-user-plus ml-2"></i> تفاصيل المدعوين
                @if($invitedBy)
                    <span class="badge badge-info ml-2" style="font-size:14px;">{{ $invitedBy }}</span>
                @endif
            </h4>
        </div>
    </div>

    {{-- فلتر --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('sitemanagement.reports.invitedByDetails') }}" class="form-inline flex-wrap gap-2">
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-user text-primary ml-1"></i> الداعي:
                    </label>
                    <select name="invited_by" class="form-control form-control-sm">
                        <option value="">-- الكل --</option>
                        @foreach($invitedByStats as $stat)
                            <option value="{{ $stat->invited_by }}" {{ $invitedBy == $stat->invited_by ? 'selected' : '' }}>
                                {{ $stat->invited_by }} ({{ number_format($stat->total) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-calendar-alt text-primary ml-1"></i> من تاريخ:
                    </label>
                    <input type="date" name="from_date" class="form-control form-control-sm"
                           value="{{ $fromDate ?? '' }}">
                </div>
                <div class="form-group ml-3 mb-2">
                    <label class="ml-2 font-weight-bold" style="white-space:nowrap;">
                        <i class="fas fa-calendar-alt text-danger ml-1"></i> إلى تاريخ:
                    </label>
                    <input type="date" name="to_date" class="form-control form-control-sm"
                           value="{{ $toDate ?? '' }}">
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-filter ml-1"></i> تصفية
                    </button>
                    <a href="{{ route('sitemanagement.reports.invitedByDetails') }}" class="btn btn-secondary btn-sm ml-2">
                        <i class="fas fa-times ml-1"></i> إلغاء
                    </a>
                    <a href="{{ route('sitemanagement.reports.index') }}" class="btn btn-dark btn-sm">
                        <i class="fas fa-arrow-right ml-1"></i> عودة للتقارير
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- النتائج --}}
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-users ml-1"></i>
                قائمة المدعوين
                @if($invitedBy)
                    بواسطة <strong class="text-primary">{{ $invitedBy }}</strong>
                @endif
                <span class="badge badge-success ml-2">{{ number_format($users->total()) }} مستخدم</span>
            </h6>
        </div>
        <div class="card-body p-0">
            @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>الاسم</th>
                            <th>رقم الموبايل</th>
                            <th>البريد الإلكتروني</th>
                            <th>الحالة</th>
                            <th>الداعي</th>
                            <th>تاريخ التسجيل</th>
                            <th style="width:80px;">عمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->MOP ?? '-' }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>
                                @if($user->status == 1)
                                    <span class="badge badge-success">نشط</span>
                                @elseif($user->status == 2)
                                    <span class="badge badge-danger">محظور</span>
                                @else
                                    <span class="badge badge-warning">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $user->invited_by ?? '-' }}</span>
                            </td>
                            <td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('sitemanagement.users.show', $user->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $users->links() }}
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-users fa-3x mb-3"></i>
                <p class="mb-0">لا توجد نتائج</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
