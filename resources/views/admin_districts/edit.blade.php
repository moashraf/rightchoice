@extends('layouts.admin')
@section('title', 'Edit District')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تحرير المنطقة</h1>
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
            {!! Form::model($district, ['route' => ['sitemanagement.districts.update', $district->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin_districts.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('sitemanagement.districts.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
