@extends('layouts.admin')

@section('title', 'تفاصيل النشاط')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-history text-primary"></i> تفاصيل النشاط #{{ $activityLog->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('sitemanagement.activityLogs.index') }}">
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
                                <th style="width: 150px;">اسم السجل</th>
                                <td>{{ $activityLog->log_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>الوصف</th>
                                <td>{{ $activityLog->description }}</td>
                            </tr>
                            <tr>
                                <th>التعليق</th>
                                <td>{{ $activityLog->comment ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>الحدث</th>
                                <td>
                                    @if($activityLog->event)
                                        @php
                                            $colors = ['created' => 'success', 'updated' => 'warning', 'deleted' => 'danger'];
                                            $color = $colors[$activityLog->event] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $color }}">{{ $activityLog->event }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>حالة الإيميل</th>
                                <td>
                                    @if($activityLog->sent_email == 0)
                                        <span class="badge badge-success">تم الإرسال</span>
                                    @else
                                        <span class="badge badge-warning">لم يتم الإرسال</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 150px;">نوع العنصر</th>
                                <td><code>{{ $activityLog->subject_type ?? '-' }}</code></td>
                            </tr>
                            <tr>
                                <th>رقم العنصر</th>
                                <td>{{ $activityLog->subject_id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>نوع المسبب</th>
                                <td><code>{{ $activityLog->causer_type ?? '-' }}</code></td>
                            </tr>
                            <tr>
                                <th>رقم المسبب</th>
                                <td>{{ $activityLog->causer_id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Batch UUID</th>
                                <td><code>{{ $activityLog->batch_uuid ?? '-' }}</code></td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <td>{{ $activityLog->created_at ? $activityLog->created_at->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>تاريخ التحديث</th>
                                <td>{{ $activityLog->updated_at ? $activityLog->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Properties JSON --}}
                @if($activityLog->properties && count($activityLog->properties) > 0)
                <div class="row mt-3">
                    <div class="col-12">
                        <h5><i class="fas fa-code"></i> الخصائص (Properties)</h5>
                        <pre style="background: #1e1e1e; color: #d4d4d4; padding: 15px; border-radius: 5px; max-height: 500px; overflow: auto; direction: ltr; text-align: left; font-size: 12px;">{{ json_encode($activityLog->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
                @endif

                <div class="row mt-3">
                    <div class="col-12">
                        {!! Form::open(['route' => ['sitemanagement.activityLogs.destroy', $activityLog->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash"></i> حذف هذا السجل', [
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
