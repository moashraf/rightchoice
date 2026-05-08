@extends('layouts.admin')
@section('title', 'تاريخ المستخدم - ' . $user->name)
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>سجل نشاط المستخدم: {{ $user->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('sitemanagement.users.show', $user->id) }}">
                        رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                @if($activities && $activities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>النشاط</th>
                                <th>الوصف</th>
                                <th>الحدث</th>
                                <th>العنصر المتأثر</th>
                                <th>التاريخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    <td>{{ $activity->log_name ?? '-' }}</td>
                                    <td>{{ $activity->description ?? '-' }}</td>
                                    <td>
                                        @if($activity->event == 'created')
                                            <span class="badge badge-success">إنشاء</span>
                                        @elseif($activity->event == 'updated')
                                            <span class="badge badge-warning">تعديل</span>
                                        @elseif($activity->event == 'deleted')
                                            <span class="badge badge-danger">حذف</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $activity->event ?? '-' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($activity->subject_type)
                                            {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $activity->created_at ? $activity->created_at->format('Y-m-d H:i:s') : '-' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $activities->links() }}
                    </div>
                @else
                    <div class="alert alert-info">لا يوجد سجل نشاط لهذا المستخدم.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

