@extends('layouts.admin')
@section('title', 'Show Property Type')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تفاصيل نوع العقار</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('admin_property_types.show_fields')
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('sitemanagement.propertyTypes.index') }}" class="btn btn-default">رجوع</a>
                <a href="{{ route('sitemanagement.propertyTypes.edit', $propertyType->id) }}" class="btn btn-primary">تعديل</a>
            </div>
        </div>
    </div>
@endsection
