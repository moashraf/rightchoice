@extends('layouts.admin')
@section('title', 'Notifications')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الإشعارات</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('sitemanagement.notifications.create') }}">
                        إضافة إشعار
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin_notifications.table')
            </div>
        </div>
    </div>
@endsection
