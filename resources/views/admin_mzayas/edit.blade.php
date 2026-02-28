@extends('layouts.admin')
@section('title', 'Edit Mzaya')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تحرير الميزة</h1>
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
            {!! Form::model($mzaya, ['route' => ['sitemanagement.mzayas.update', $mzaya->id], 'method' => 'patch', 'files' => true]) !!}

            <div class="card-body">
                <div class="row">
                    @if($mzaya->img_name)
                        <div class="col-sm-12 mb-3">
                            <label>Current Image:</label><br>
                            <img src="{{ asset('uploads/mzaya/' . $mzaya->img_name) }}" alt="" style="max-height:120px;" class="img-thumbnail">
                        </div>
                    @endif
                    @include('admin_mzayas.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('sitemanagement.mzayas.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
