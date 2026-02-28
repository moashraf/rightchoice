@extends('layouts.admin')
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

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card">

            {!! Form::model($blog, ['route' => ['sitemanagement.blogs.update', $blog->id], 'method' => 'patch' ,'files' => true,'enctype' => 'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin_blogs.fields',['btnClass'=>'primary','type'=>'show'])
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('sitemanagement.blogs.index') }}" class="btn btn-default">الغاء</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
