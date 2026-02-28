<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'ID:') !!}
    <p>{{ $complaints->id }}</p>
</div>

<!-- User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'المستخدم:') !!}
    <p>{{ $complaints->userinfo ? $complaints->userinfo->name : '-' }}</p>
</div>

<!-- Aqar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('aqars_id', 'العقار:') !!}
    <p>{{ $complaints->aqarinfo ? $complaints->aqarinfo->title : '-' }}</p>
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
