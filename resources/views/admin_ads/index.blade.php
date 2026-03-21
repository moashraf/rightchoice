@extends('layouts.admin')
@section('title', 'اعلانات خارجية')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>اعلانات خارجية</h1>
                </div>
                <div class="col-sm-6">
                    @php $authUser = auth()->guard('admin')->user() ?? auth()->user(); @endphp
                    @if($authUser && $authUser->hasPermission('ads.create'))
                        <a class="btn btn-primary float-right" href="{{ route('sitemanagement.ads.create') }}">
                            اضف جديد
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
            <div class="card-body p-0">
                @include('admin_ads.table')
            </div>
        </div>
    </div>
@endsection
