@extends('layouts.admin')
@section('title', 'العقارات')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>العقارات</h1>
                </div>
                <div class="col-sm-6 text-right">
                    @php $authUser = auth()->guard('admin')->user() ?? auth()->user(); @endphp
                    @if($authUser && $authUser->hasPermission('aqars.delete'))
                        <a class="btn btn-danger mr-2" href="{{ route('sitemanagement.aqars.deleted') }}">
                            <i class="fas fa-trash-restore mr-1"></i> العقارات المحذوفة
                        </a>
                    @endif
                    @if($authUser && $authUser->hasPermission('aqars.create'))
                        <a class="btn btn-primary" href="{{ route('sitemanagement.aqars.create') }}">
                            <i class="fas fa-plus mr-1"></i> إضافة جديد
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body">
                @include('admin_aqars.table')
            </div>
        </div>
    </div>
@endsection
