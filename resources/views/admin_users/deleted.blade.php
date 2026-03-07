@extends('layouts.admin')
@section('title', 'المستخدمون المحذوفون')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fas fa-user-slash ml-2 text-danger"></i>
                        المستخدمون المحذوفون
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('sitemanagement.users.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-right ml-1"></i> العودة للمستخدمين
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="card">

            <form action="{{ route('sitemanagement.users.deleted') }}" class="container justify-content-center m-3 row align-items-end">
                <div class="row justify-content-center m-2 w-100">
                    <div class="col-md-4">
                        <label>
                            بحث باسم المستخدم أو رقم الهاتف
                            <input type="text" class="form-control" name="search_key"
                                   placeholder="بحث ..." value="{{ request('search_key') }}">
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label>اظهار</label>
                        <select name="show" class="form-control">
                            <option value="10">10</option>
                            <option value="25" {{ 25 == request('show') ? 'selected' : '' }}>25</option>
                            <option value="50" {{ 50 == request('show') ? 'selected' : '' }}>50</option>
                            <option value="100" {{ 100 == request('show') ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-success w-100">
                            <i class="fa fa-filter"></i> بحث
                        </button>
                    </div>
                </div>
            </form>

            <div class="card-body p-0">

                @if($users->total() > 0)
                    <div class="alert alert-warning mx-3 mt-2">
                        <i class="fas fa-exclamation-triangle ml-1"></i>
                        إجمالي المستخدمين المحذوفين: <strong>{{ $users->total() }}</strong> مستخدم —
                        الحسابات محذوفة مؤقتاً (Soft Delete) ويمكن استعادتها أو حذفها نهائياً.
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>النوع</th>
                            <th>تاريخ التسجيل</th>
                            <th>تاريخ الحذف</th>
                            <th>الإجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr class="table-danger">
                                <td>{{ $user->id }}</td>
                                <td>
                                    {{ $user->name }}
                                    <br><span class="badge badge-danger">محذوف</span>
                                </td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>{{ $user->MOP ?? '-' }}</td>
                                <td>{{ $user->getUserType() }}</td>
                                <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <span class="text-danger">
                                        <i class="fas fa-calendar-times ml-1"></i>
                                        {{ $user->deleted_at->format('Y-m-d H:i') }}
                                    </span>
                                </td>
                                <td>
                                    {{-- Restore --}}
                                    <form action="{{ route('sitemanagement.users.restore', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning ml-1"
                                                onclick="return confirm('هل تريد استعادة حساب {{ addslashes($user->name) }}؟')"
                                                data-toggle="tooltip" title="استعادة الحساب">
                                            <i class="fas fa-undo"></i> استعادة
                                        </button>
                                    </form>

                                    {{-- Force Delete --}}
                                    <form action="{{ route('sitemanagement.users.forceDelete', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('تحذير! سيتم حذف حساب {{ addslashes($user->name) }} نهائياً ولا يمكن التراجع. هل أنت متأكد؟')"
                                                data-toggle="tooltip" title="حذف نهائي">
                                            <i class="fas fa-trash-alt"></i> حذف نهائي
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                                    لا يوجد مستخدمون محذوفون حالياً.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
