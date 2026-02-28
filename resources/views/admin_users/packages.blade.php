@extends('layouts.admin')
@section('title', 'الباقات - ' . $user->name)
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الباقات المشترك بها المستخدم: {{ $user->name }}</h1>
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
                @if($packages && $packages->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الباقة</th>
                                <th>النقاط المبدئية</th>
                                <th>النقاط الحالية</th>
                                <th>النقاط المستخدمة</th>
                                <th>الحالة</th>
                                <th>تاريخ الاشتراك</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($packages as $package)
                                <tr>
                                    <td>{{ $package->id }}</td>
                                    <td>{{ $package->pricing->type ?? 'باقة محذوفة' }}</td>
                                    <td>{{ $package->start_points ?? 0 }}</td>
                                    <td>{{ $package->current_points ?? 0 }}</td>
                                    <td>{{ $package->sub_points ?? 0 }}</td>
                                    <td>
                                        @if(($package->current_points ?? 0) > 0)
                                            <span class="badge badge-success">نشط</span>
                                        @else
                                            <span class="badge badge-danger">منتهي</span>
                                        @endif
                                    </td>
                                    <td>{{ $package->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>لا توجد باقات لهذا المستخدم.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
