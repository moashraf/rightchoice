@extends('layouts.admin')
@section('title', 'إضافة مستخدم')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>إضافة مستخدم جديد</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <form action="{{ route('sitemanagement.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        @include('admin_users.fields')
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <a href="{{ route('sitemanagement.users.index') }}" class="btn btn-default">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection
