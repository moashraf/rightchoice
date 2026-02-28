@extends('layouts.admin')
@section('title', 'Property Types')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>أنواع العقارات</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('sitemanagement.propertyTypes.create') }}">
                        إضافة جديد
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
                @include('admin_property_types.table')
            </div>
        </div>
    </div>
@endsection
