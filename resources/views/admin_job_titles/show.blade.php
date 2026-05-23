@extends('layouts.admin')
@section('title', 'تفاصيل المسمى الوظيفي')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تفاصيل المسمى الوظيفي</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('sitemanagement.jobTitles.index') }}">
                        رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('admin_job_titles.show_fields')
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('sitemanagement.jobTitles.edit', $jobTitle->id) }}" class="btn btn-primary">تعديل</a>
                <a href="{{ route('sitemanagement.jobTitles.index') }}" class="btn btn-default">رجوع</a>
            </div>
        </div>
    </div>
@endsection
