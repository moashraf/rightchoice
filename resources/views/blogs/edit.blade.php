@extends('layouts.app')
@section('title', 'Edit Blog')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تحرير المدونة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::model($blog, ['route' => ['blogs.update', $blog->id], 'method' => 'patch' ,'files' => true,'enctype' => 'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">
                    @include('blogs.fields',['btnClass'=>'primary','type'=>'show'])
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('blogs.index') }}" class="btn btn-default">الغاء</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
