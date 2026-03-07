@extends('layouts.admin')
@section('title', 'طلبات حذف الحسابات')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>طلبات حذف الحسابات</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <form action="{{ route('sitemanagement.accountDeleteRequests.index') }}" method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label>بحث باسم المستخدم أو رقمه</label>
                            <input type="text" class="form-control" name="search_key"
                                   placeholder="بحث ..." value="{{ request('search_key') }}">
                        </div>
                        <div class="col-md-3">
                            <label>الحالة</label>
                            <select class="form-control" name="filter_status">
                                <option value="">الكل</option>
                                <option value="pending"  {{ request('filter_status') == 'pending'  ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="approved" {{ request('filter_status') == 'approved' ? 'selected' : '' }}>موافق عليه</option>
                                <option value="rejected" {{ request('filter_status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>اظهار</label>
                            <select name="show" class="form-control">
                                <option value="10">10</option>
                                <option value="25"  {{ request('show') == 25  ? 'selected' : '' }}>25</option>
                                <option value="50"  {{ request('show') == 50  ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fa fa-filter ml-1"></i> بحث
                            </button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('sitemanagement.accountDeleteRequests.index') }}" class="btn btn-secondary btn-block">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>اسم المستخدم</th>
                            <th>رقم الهاتف</th>
                            <th>سبب الطلب</th>
                            <th>الحالة</th>
                            <th>ملاحظة الأدمن</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($deleteRequests as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>
                                    @if($req->user)
                                        {{ $req->user->name }}
                                        <br><small class="text-muted">ID: {{ $req->user_id }}</small>
                                        @if($req->user->deleted_at)
                                            <br><span class="badge badge-danger">محذوف (Soft)</span>
                                        @endif
                                    @else
                                        <span class="text-muted">(مستخدم غير موجود)</span>
                                    @endif
                                </td>
                                <td>{{ $req->user->MOP ?? '-' }}</td>
                                <td>
                                    <span title="{{ $req->reason }}">
                                        {{ \Str::limit($req->reason, 60) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $req->status_badge }}">
                                        {{ $req->status_label }}
                                    </span>
                                </td>
                                <td>{{ $req->admin_note ?? '-' }}</td>
                                <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($req->status === 'pending')
                                        {{-- Approve Button --}}
                                        <button type="button" class="btn btn-sm btn-success ml-1"
                                                data-toggle="modal"
                                                data-target="#approveModal{{ $req->id }}">
                                            <i class="fas fa-check"></i> قبول
                                        </button>

                                        {{-- Reject Button --}}
                                        <button type="button" class="btn btn-sm btn-danger"
                                                data-toggle="modal"
                                                data-target="#rejectModal{{ $req->id }}">
                                            <i class="fas fa-times"></i> رفض
                                        </button>
                                    @elseif($req->status === 'approved')
                                        <span class="badge badge-success ml-1">تم الحذف</span>
                                        {{-- Restore Button --}}
                                        <form action="{{ route('sitemanagement.accountDeleteRequests.restore', $req->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning"
                                                    onclick="return confirm('هل تريد استعادة حساب هذا المستخدم؟')">
                                                <i class="fas fa-undo"></i> استعادة الحساب
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge badge-secondary">مرفوض</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- Approve Modal --}}
                            @if($req->status === 'pending')
                            <div class="modal fade" id="approveModal{{ $req->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('sitemanagement.accountDeleteRequests.approve', $req->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title">قبول طلب حذف الحساب</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle ml-1"></i>
                                                    <strong>ملاحظة:</strong> سيتم تعطيل الحساب مؤقتاً <strong>(Soft Delete)</strong> — يمكن استعادته لاحقاً من نفس الصفحة.
                                                </div>
                                                <p>المستخدم: <strong>{{ $req->user->name ?? '' }}</strong></p>
                                                <div class="form-group">
                                                    <label>ملاحظة للسجل (اختياري)</label>
                                                    <textarea name="admin_note" class="form-control" rows="3" placeholder="ملاحظة..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-check ml-1"></i> تأكيد القبول وتعطيل الحساب
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Reject Modal --}}
                            <div class="modal fade" id="rejectModal{{ $req->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('sitemanagement.accountDeleteRequests.reject', $req->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">رفض طلب حذف الحساب</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>سيتم رفض طلب حذف الحساب للمستخدم <strong>{{ $req->user->name ?? '' }}</strong>.</p>
                                                <div class="form-group">
                                                    <label>سبب الرفض <span class="text-danger">*</span></label>
                                                    <textarea name="admin_note" class="form-control" rows="3" placeholder="اكتب سبب الرفض..." required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">لا توجد طلبات حذف حسابات.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $deleteRequests->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
