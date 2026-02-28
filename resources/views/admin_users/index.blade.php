@extends('layouts.admin')
@section('title', 'المستخدمون')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>المستخدمون</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('sitemanagement.users.create') }}">
                        اضف جديد
                    </a>
                    <a id="export-users-btn" class="btn btn-success float-right mr-2"
                       href="{{ route('sitemanagement.users.exportUsers', array_filter([
                           'search_key'    => request('search_key'),
                           'filter_status' => request('filter_status'),
                           'filter_type'   => request('filter_type'),
                           'sortBy'        => request('sortBy'),
                       ])) }}">
                        <i class="fa fa-file-excel ml-1"></i>
                        <span id="export-users-text">تصدير نتائج البحث</span>
                        <span id="export-users-spinner" style="display:none"><i class="fa fa-spinner fa-spin"></i> جاري التصدير...</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">

            <form action="{{ route('sitemanagement.users.index') }}" class="container justify-content-center m-3 row align-items-end">
                <div class="row justify-content-center m-2">
                    <div class="col-md-3">
                        <label>
                            بحث
                            <input type="text" class="form-control" name="search_key"
                                   placeholder="بحث ... " value="{{ request('search_key') }}">
                        </label>
                    </div>
                    <div class="row col-md-3 align-items-center">
                        <div class="col-md-6">
                            <label>
                                اظهار
                                <select name="show" class="form-control">
                                    <option value="10">10</option>
                                    <option value="25" {{ 25 == request('show') ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ 50 == request('show') ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ 100 == request('show') ? 'selected' : '' }}>100</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 m-2">
                    <label>الحالة</label>
                    <select class="form-control" name="filter_status">
                        <option value="">اختر</option>
                        @foreach(\App\Enums\UserStatusEnum::values() as $key => $case)
                            <option value="{{ $case }}" {{ request('filter_status') !== null ? (request('filter_status') == $case ? 'selected' : '') : '' }}>{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 m-2">
                    <label>النوع</label>
                    <select class="form-control" name="filter_type">
                        <option value="">اختر</option>
                        @foreach(\App\Enums\UserTypeEnum::values() as $key => $case)
                            <option value="{{ $case }}" {{ request('filter_type') !== null ? (request('filter_type') == $case ? 'selected' : '') : '' }}>{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 m-2">
                    <label>ترتيب حسب</label>
                    <select class="form-control" name="sortBy">
                        <option value="">اختر</option>
                        <option value="0" {{ request('sortBy') !== null ? (request('sortBy') == 0 ? 'selected' : '') : '' }}>من الاحدث للاقدم</option>
                        <option value="1" {{ request('sortBy') !== null ? (request('sortBy') == 1 ? 'selected' : '') : '' }}>من الاقدم للاحدث</option>
                    </select>
                </div>

                <div class="row justify-content-center">
                    <button class="btn btn-success col-md-2">
                        <i class="fa fa-filter"></i>
                    </button>
                </div>
            </form>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>اسم</th>
                            <th>نوع</th>
                            <th>الباقة</th>
                            <th>التليفون المحمول</th>
                            <th>التاريخ</th>
                            <th>حالة</th>
                            <th>حدث</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->getUserType() }}</td>
                                <td>
                                    @foreach($user->UserPriceing as $val)
                                        {{ $val->type ?? '' }}
                                    @endforeach
                                </td>
                                <td>{{ $user->MOP }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="badge badge-success">{{ $user->getStatus() }}</span>
                                    @elseif($user->status == 0)
                                        <span class="badge badge-warning">{{ $user->getStatus() }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $user->getStatus() }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->status == 1)
                                        <a onClick="return confirm('هل انت متأكد من حظر هذا المستخدم؟')"
                                           data-toggle="tooltip" title="حظر المستخدم"
                                           href="{{ route('sitemanagement.users.block', $user->id) }}"
                                           class="btn btn-sm btn-outline-danger ml-2">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @else
                                        <a onClick="return confirm('هل انت متأكد من تفعيل هذا المستخدم؟')"
                                           data-toggle="tooltip" title="تفعيل المستخدم"
                                           href="{{ route('sitemanagement.users.activate', $user->id) }}"
                                           class="btn btn-sm btn-outline-success ml-2">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    @endif
                                    <a onClick="return confirm('هل انت متأكد من حذف هذا السجل؟')"
                                       data-toggle="tooltip" title="حذف"
                                       href="{{ route('sitemanagement.users.delete', $user->id) }}"
                                       class="btn btn-sm btn-outline-danger ml-2">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="{{ route('sitemanagement.users.edit', $user->id) }}"
                                       class="btn btn-sm btn-outline-info ml-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('sitemanagement.users.show', $user->id) }}"
                                       class="btn btn-sm btn-outline-primary ml-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var exportBtn = document.getElementById('export-users-btn');
            var exportText = document.getElementById('export-users-text');
            var exportSpinner = document.getElementById('export-users-spinner');
            if (exportBtn) {
                exportBtn.addEventListener('click', function (e) {
                    exportBtn.classList.add('disabled');
                    exportText.style.display = 'none';
                    exportSpinner.style.display = '';
                    setTimeout(function () {
                        exportBtn.classList.remove('disabled');
                        exportText.style.display = '';
                        exportSpinner.style.display = 'none';
                    }, 5000);
                });
            }
        });
    </script>
@endsection
