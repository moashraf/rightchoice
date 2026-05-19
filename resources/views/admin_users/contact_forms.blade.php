@extends('layouts.admin')
@section('title', 'نماذج الاتصال - ' . $user->name)
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>نماذج الاتصال للمستخدم: {{ $user->name }}</h1>
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
                @if($contactForms && $contactForms->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>العقار</th>
                                <th>طريقة التواصل</th>
                                <th>تاريخ التواصل</th>
                                <th>حدث</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contactForms as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->all_aqat_viw->title ?? 'عقار محذوف' }}</td>
                                    <td>
                                        @if($contact->contact_via_whats_app)
                                            <span class="badge badge-success" style="font-size:13px;padding:6px 10px;">
                                                <img src="https://img.icons8.com/color/16/000000/whatsapp--v1.png" width="16" height="16"/>
                                                واتساب
                                            </span>
                                        @else
                                            <span class="badge badge-info" style="font-size:13px;padding:6px 10px;">
                                                <i class="fas fa-phone ml-1"></i> اتصال / عرض رقم
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $contact->created_at ? $contact->created_at->format('Y-m-d H:i') : '—' }}</td>
                                    <td>
                                        @if($contact->all_aqat_viw)
                                            <a href="{{ route('sitemanagement.aqars.show', $contact->aqars_id) }}"
                                               class="btn btn-sm btn-primary">
                                                عرض العقار
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>لا توجد نماذج اتصال لهذا المستخدم.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
