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

        @if(request()->filled('filter_user_id'))
        @php
            $filteredUser = \App\Models\User::find(request('filter_user_id'));
        @endphp
        @if($filteredUser)
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-filter ml-1"></i>
                عرض عقارات المستخدم:
                <strong>{{ $filteredUser->name }}</strong>
                ({{ $filteredUser->MOP }})
            </span>
            <div>
                <a href="{{ route('sitemanagement.users.show', $filteredUser->id) }}"
                   class="btn btn-sm btn-outline-primary ml-2">
                    <i class="fas fa-user ml-1"></i> بيانات المستخدم
                </a>
                <a href="{{ route('sitemanagement.aqars.index') }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times ml-1"></i> إلغاء الفلتر
                </a>
            </div>
        </div>
        @endif
        @endif

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body">
                @include('admin_aqars.table')
            </div>
        </div>
    </div>
@endsection
