<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'ID:') !!}
    <p>{{ $complaints->id }}</p>
</div>

<!-- User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'المستخدم:') !!}
    <p>
        @if($user)
            <a href="#" data-toggle="modal" data-target="#userModal" class="badge badge-info p-2" style="font-size:14px; cursor:pointer;">
                <i class="fa fa-user ml-1"></i> {{ $user->name }}
            </a>
        @else
            <span class="text-muted">-</span>
        @endif
    </p>
</div>

<!-- Aqar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('aqars_id', 'العقار:') !!}
    <p>
        @if($aqar)
            <a href="#" data-toggle="modal" data-target="#aqarModal" class="badge badge-warning p-2" style="font-size:14px; cursor:pointer;">
                <i class="fa fa-home ml-1"></i> {{ $aqar->title }}
            </a>
        @else
            <span class="text-muted">-</span>
        @endif
    </p>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'الحالة:') !!}
    <p>
        @if($complaints->status == \App\Models\Complaints::COMPLAINT_PENDING)
            <span class="badge badge-warning">متوقف</span>
        @elseif($complaints->status == \App\Models\Complaints::COMPLAINT_INPROGRESS)
            <span class="badge badge-info">جاري العمل عليه</span>
        @elseif($complaints->status == \App\Models\Complaints::COMPLAINT_SOLVED)
            <span class="badge badge-success">تم الحل</span>
        @else
            -
        @endif
    </p>
</div>

<!-- Message Field -->
<div class="form-group col-sm-12">
    {!! Form::label('message', 'الرسالة:') !!}
    <p>{{ $complaints->message }}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'تاريخ الإرسال:') !!}
    <p>{{ $complaints->created_at }}</p>
</div>

{{-- ====== User Modal ====== --}}
@if($user)
<div class="modal fade" id="userModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fa fa-user ml-1"></i> بيانات المستخدم</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/'.$user->profile_image) }}" class="img-circle img-fluid"
                                 style="width:100px;height:100px;object-fit:cover;"    >
                        @else
                            <i class="fa fa-user-circle fa-5x text-muted"></i>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <table class="table table-sm table-bordered">
                            <tr><td class="font-weight-bold" width="35%">الاسم</td><td>{{ $user->name }}</td></tr>
                            <tr><td class="font-weight-bold">البريد الإلكتروني</td><td>{{ $user->email ?? '-' }}</td></tr>
                            <tr><td class="font-weight-bold">رقم الهاتف</td><td>{{ $user->MOP ?? '-' }}</td></tr>
                            <tr><td class="font-weight-bold">النوع</td><td>{{ $user->TYPE ?? '-' }}</td></tr>
                            <tr><td class="font-weight-bold">المسمى الوظيفي</td><td>{{ $user->Job_title ?? '-' }}</td></tr>
                            <tr><td class="font-weight-bold">الحالة</td><td>
                                @if($user->status == 1)
                                    <span class="badge badge-success">نشط</span>
                                @elseif($user->status == 2)
                                    <span class="badge badge-danger">محظور</span>
                                @else
                                    <span class="badge badge-secondary">{{ $user->status }}</span>
                                @endif
                            </td></tr>
                            <tr><td class="font-weight-bold">تاريخ التسجيل</td><td>{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('sitemanagement.users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="fa fa-edit ml-1"></i> تعديل المستخدم
                </a>
                <a href="{{ route('sitemanagement.users.show', $user->id) }}" class="btn btn-info">
                    <i class="fa fa-eye ml-1"></i> عرض الملف
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ====== Aqar Modal ====== --}}
@if($aqar)
<div class="modal fade" id="aqarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fa fa-home ml-1"></i> بيانات العقار</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered">
                    <tr><td class="font-weight-bold" width="35%">العنوان</td><td>{{ $aqar->title ?? '-' }}</td></tr>
                    <tr><td class="font-weight-bold">السعر</td><td>{{ $aqar->price ?? '-' }}</td></tr>
                    <tr><td class="font-weight-bold">المساحة</td><td>{{ $aqar->area ?? '-' }}</td></tr>
                    <tr><td class="font-weight-bold">المحافظة</td><td>{{ $aqar->governrate->title ?? '-' }}</td></tr>
                    <tr><td class="font-weight-bold">الحي</td><td>{{ $aqar->district->title ?? '-' }}</td></tr>
                    <tr><td class="font-weight-bold">الحالة</td><td>{{ $aqar->status ?? '-' }}</td></tr>
                    <tr><td class="font-weight-bold">المالك</td><td>{{ $aqar->user->name ?? '-' }}</td></tr>
                    <tr><td class="font-weight-bold">تاريخ الإضافة</td><td>{{ $aqar->created_at ? $aqar->created_at->format('Y-m-d H:i') : '-' }}</td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('sitemanagement.aqars.edit', $aqar->id) }}" class="btn btn-primary">
                    <i class="fa fa-edit ml-1"></i> تعديل العقار
                </a>
                <a href="{{ route('sitemanagement.aqars.show', $aqar->id) }}" class="btn btn-warning">
                    <i class="fa fa-eye ml-1"></i> عرض العقار
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
@endif
