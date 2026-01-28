@extends('layouts.app')
@section('title', 'Create Floor')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>إنشاء طابق</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::open(['route' => 'floors.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('floors.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('floors.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
