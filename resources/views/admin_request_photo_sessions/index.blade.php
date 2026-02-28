@extends('layouts.admin')
@section('title', 'Request Photo Sessions')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>طلبات جلسات التصوير</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin_request_photo_sessions.table')
            </div>
        </div>
    </div>
@endsection
