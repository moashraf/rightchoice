@extends('layouts.app')
@section('title', 'Edit Contact Form')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تحرير نموذج الاتصال</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($contactForm, ['route' => ['contactForms.update', $contactForm->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('contact_forms.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('contactForms.index') }}" class="btn btn-default">الغاء</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
