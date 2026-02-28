@extends('layouts.admin')
@section('title', 'Aqar Categories')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>فئات العقارات</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('sitemanagement.aqarCategories.create') }}">
                        اضف جديد
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
                @include('admin_aqar_categories.table')
            </div>
        </div>
    </div>
@endsection
