@extends('layouts.admin')
@section('title', 'Companies')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الشركات</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('sitemanagement.companies.create') }}">
                        اضف جديد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        {{-- Filter Form --}}
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fa fa-filter mr-1"></i> بحث وفلترة</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('sitemanagement.companies.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label class="small font-weight-bold">اسم الشركة</label>
                            <input type="text" id="filter_name" name="filter_name" class="form-control form-control-sm"
                                   placeholder="ابحث باسم الشركة..." value="{{ request('filter_name') }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="small font-weight-bold">المحافظة</label>
                            <select id="filter_governrate" name="filter_governrate" class="form-control form-control-sm">
                                <option value="">الكل</option>
                                @foreach($governrates as $id => $name)
                                    <option value="{{ $id }}" {{ request('filter_governrate') == $id ? 'selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="small font-weight-bold">الحي</label>
                            <select id="filter_district" name="filter_district" class="form-control form-control-sm">
                                <option value="">الكل</option>
                                @foreach($districts as $id => $name)
                                    <option value="{{ $id }}" {{ request('filter_district') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="small font-weight-bold">الخدمة</label>
                            <select id="filter_service" name="filter_service" class="form-control form-control-sm">
                                <option value="">الكل</option>
                                @foreach($services as $id => $name)
                                    <option value="{{ $id }}" {{ request('filter_service') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="small font-weight-bold">الحالة</label>
                            <select id="filter_status" name="filter_status" class="form-control form-control-sm">
                                <option value="">الكل</option>
                                @foreach($statuses as $val => $label)
                                    <option value="{{ $val }}" {{ request('filter_status') !== null && request('filter_status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 mb-2 d-flex align-items-end">
                            <div class="w-100">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{ route('sitemanagement.companies.index') }}" class="btn btn-secondary btn-sm btn-block mt-1">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin_companies.table')
            </div>
        </div>
    </div>
@endsection
