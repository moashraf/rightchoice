@extends('layouts.admin')
@section('title', 'Show Contact Form')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تفاصيل الرسالة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('admin_contact_forms.show_fields')
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('sitemanagement.contactForms.index') }}" class="btn btn-default">رجوع</a>
            </div>
        </div>
    </div>
@endsection
