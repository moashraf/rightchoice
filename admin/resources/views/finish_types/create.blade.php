@extends('layouts.app')
@section('title', 'Finish Type')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Finish Type</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::open(['route' => 'finishTypes.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('finish_types.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('finishTypes.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
