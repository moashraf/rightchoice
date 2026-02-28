@extends('layouts.admin')
@section('title', 'Create Contact Form')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>إضافة رسالة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            {!! Form::open(['route' => 'sitemanagement.contactForms.store']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin_contact_forms.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('sitemanagement.contactForms.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
