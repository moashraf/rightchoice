@extends('layouts.app')
@section('title', 'Edit Setting Site')
@section('headerStyle')
<style>

    .bootstrap-tagsinput input {
        min-height: 27px;
   }
</style>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تعديل اعدادات الموفع</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::model($settingSite, ['route' => ['settingSites.update', $settingSite->id], 'method' => 'patch','files' => true,'enctype' => 'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">
                    @include('setting_sites.fields',['type'=>'show'])
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('settingSites.index') }}" class="btn btn-default">الغاء</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
