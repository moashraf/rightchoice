@extends('layouts.admin')
@section('title', 'Pages')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الصفحات</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-outline-primary ml-2" href="{{ route('sitemanagement.privacy-policy-sections.index') }}">
                        <i class="fas fa-user-shield ml-1"></i>
                        سياسة الخصوصية
                    </a>
                    <a class="btn btn-primary" href="{{ route('sitemanagement.pages.create') }}">
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
                @include('admin_pages.table')
            </div>
        </div>
    </div>
@endsection
