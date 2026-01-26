@extends('layouts.app')
@section('title', 'user Details')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تفاصيل المستخدم</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right ml-2"
                       href="{{ route('user.aqars', $user->id) }}">
                        عرض العقارات
                    </a>
                    <a class="btn btn-default float-right"
                       href="{{ route('user.index') }}">
                        رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    @include('user.show_fields')
                </div>
            </div>

        </div>
    </div>
@endsection
