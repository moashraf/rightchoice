@extends('layouts.admin')
@section('title', 'تفاصيل المستخدم')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تفاصيل المستخدم</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right ml-2"
                       href="{{ route('sitemanagement.users.aqars', $user->id) }}">
                        عرض العقارات
                    </a>
                    <a class="btn btn-info float-right ml-2"
                       href="{{ route('sitemanagement.users.contactForms', $user->id) }}">
                        نماذج الاتصال
                    </a>
                    <a class="btn btn-success float-right ml-2"
                       href="{{ route('sitemanagement.users.packages', $user->id) }}">
                        عرض الباقات
                    </a>
                    <a class="btn btn-warning float-right ml-2"
                       href="{{ route('sitemanagement.complaints.index', ['user_id' => $user->id]) }}">
                        عرض الشكاوى
                    </a>
                    <a class="btn btn-default float-right"
                       href="{{ route('sitemanagement.users.index') }}">
                        رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('admin_users.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
