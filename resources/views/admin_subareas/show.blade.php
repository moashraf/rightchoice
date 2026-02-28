@extends('layouts.admin')
@section('title', 'Sub Area Details')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تفاصيل المنطقة الفرعية</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('sitemanagement.subareas.index') }}">
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
                    @include('admin_subareas.show_fields')
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('sitemanagement.subareas.edit', $subarea->id) }}" class="btn btn-primary">تعديل</a>
                <a href="{{ route('sitemanagement.subareas.index') }}" class="btn btn-default">رجوع</a>
            </div>
        </div>
    </div>
@endsection
