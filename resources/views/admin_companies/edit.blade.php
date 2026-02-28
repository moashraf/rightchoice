@extends('layouts.admin')
@section('title', 'Edit Company')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تحرير الشركة</h1>
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
            {!! Form::model($company, ['route' => ['sitemanagement.companies.update', $company->id], 'method' => 'patch', 'files' => true]) !!}

            <div class="card-body">
                <div class="row">
                    @if($company->photo)
                        <div class="col-sm-12 mb-3">
                            <label>Current Photo:</label><br>
                            <img src="{{ asset('uploads/company/' . $company->photo) }}" alt="" style="max-height:120px;" class="img-thumbnail">
                        </div>
                    @endif
                    @include('admin_companies.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('sitemanagement.companies.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
