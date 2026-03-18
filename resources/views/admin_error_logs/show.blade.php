@extends('layouts.admin')

@section('title', 'تفاصيل الخطأ')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-bug text-danger"></i> تفاصيل الخطأ #{{ $errorLog->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('sitemanagement.errorLogs.index') }}">
                        <i class="fas fa-arrow-left"></i> رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 150px;">نوع الخطأ</th>
                                <td><code>{{ $errorLog->type }}</code></td>
                            </tr>
                            <tr>
                                <th>الرسالة</th>
                                <td>{{ $errorLog->message }}</td>
                            </tr>
                            <tr>
                                <th>الملف</th>
                                <td><code>{{ $errorLog->file }}</code></td>
                            </tr>
                            <tr>
                                <th>السطر</th>
                                <td><span class="badge badge-info">{{ $errorLog->line }}</span></td>
                            </tr>
                            <tr>
                                <th>عدد مرات التكرار</th>
                                <td><span class="badge badge-danger" style="font-size: 1.1em;">{{ $errorLog->count }}</span></td>
                            </tr>
                            <tr>
                                <th>أول حدوث</th>
                                <td>{{ $errorLog->first_occurred_at ? $errorLog->first_occurred_at->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>آخر حدوث</th>
                                <td>{{ $errorLog->last_occurred_at ? $errorLog->last_occurred_at->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h5><i class="fas fa-code"></i> Stack Trace</h5>
                        <pre style="background: #1e1e1e; color: #d4d4d4; padding: 15px; border-radius: 5px; max-height: 500px; overflow: auto; direction: ltr; text-align: left; font-size: 12px;">{{ $errorLog->trace }}</pre>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        {!! Form::open(['route' => ['sitemanagement.errorLogs.destroy', $errorLog->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash"></i> حذف هذا الخطأ', [
                                'type'    => 'submit',
                                'class'   => 'btn btn-danger',
                                'onclick' => "return confirm('هل أنت متأكد من الحذف؟')"
                            ]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
