@extends('layouts.app')
@section('title', 'Edit Aqar Category')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Aqar Category</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::model($aqarCategory, ['route' => ['aqarCategories.update', $aqarCategory->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('aqar_categories.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('aqarCategories.index') }}" class="btn btn-default">Cancel</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
