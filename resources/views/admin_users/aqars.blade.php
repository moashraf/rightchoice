@extends('layouts.admin')
@section('title', 'عقارات المستخدم')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>عقارات المستخدم: {{ $user->name }}</h1>
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
                @if($aqars && $aqars->count() > 0)
                    <ul class="list-group">
                        @foreach($aqars as $aqar)
                            <li class="list-group-item">
                                <strong>{{ $aqar->title ?? '' }}</strong> - {{ $aqar->location ?? '' }} - {{ $aqar->total_price ?? 0 }} EGP
                                <a href="{{ route('sitemanagement.aqars.show', $aqar->id) }}" class="btn btn-sm btn-primary float-right">عرض</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>لا توجد عقارات لهذا المستخدم.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
