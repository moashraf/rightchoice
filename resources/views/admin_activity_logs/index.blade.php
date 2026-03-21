@extends('layouts.admin')

@section('title', 'سجل النشاطات')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-history text-primary"></i> سجل النشاطات</h1>
                </div>
                <div class="col-sm-6">
                    {!! Form::open(['route' => 'sitemanagement.activityLogs.clearAll', 'method' => 'POST', 'style' => 'display:inline', 'class' => 'float-right']) !!}
                        {!! Form::button('<i class="fa fa-trash"></i> مسح جميع السجلات', [
                            'type'    => 'submit',
                            'class'   => 'btn btn-danger',
                            'onclick' => "return confirm('هل أنت متأكد من مسح جميع سجلات النشاطات؟')"
                        ]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin_activity_logs.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
