@extends('layouts.admin')
@section('title', 'Show Complaint')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تفاصيل الشكوى</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('admin_complaints.show_fields')
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('sitemanagement.complaints.index') }}" class="btn btn-default">رجوع</a>
                @php $authUser = auth()->guard('admin')->user() ?? auth()->user(); @endphp
                @if($authUser && $authUser->hasPermission('complaints.update'))
                    <a href="{{ route('sitemanagement.complaints.edit', $complaints->id) }}" class="btn btn-primary">تعديل</a>
                @endif
            </div>
        </div>
    </div>
@endsection
