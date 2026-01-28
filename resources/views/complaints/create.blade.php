@extends('layouts.app')
@section('title', 'Create Complaints')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>إنشاء شكاوى</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::open(['route' => 'complaints.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('complaints.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('complaints.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
