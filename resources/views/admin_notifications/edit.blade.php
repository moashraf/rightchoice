@extends('layouts.admin')
@section('title', 'Edit Notification')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تعديل إشعار</h1>
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
            {!! Form::model($notification, ['route' => ['sitemanagement.notifications.update', $notification->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin_notifications.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('sitemanagement.notifications.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
