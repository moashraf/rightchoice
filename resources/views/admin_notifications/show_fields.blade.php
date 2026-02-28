<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'ID:') !!}
    <p>{{ $notification->id }}</p>
</div>

<!-- User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'المستخدم:') !!}
    <p>{{ $notification->userinfo->name ?? '-' }}</p>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'النوع:') !!}
    <p>{{ $notification->type == 1 ? 'كل المستخدمين' : 'مستخدم محدد' }}</p>
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'العنوان:') !!}
    <p>{{ $notification->title }}</p>
</div>

<!-- Title En Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title_en', 'العنوان (إنجليزي):') !!}
    <p>{{ $notification->title_en }}</p>
</div>

<!-- Message Field -->
<div class="form-group col-sm-12">
    {!! Form::label('message', 'الرسالة:') !!}
    <p>{{ $notification->message }}</p>
</div>

<!-- Message En Field -->
<div class="form-group col-sm-12">
    {!! Form::label('message_en', 'الرسالة (إنجليزي):') !!}
    <p>{{ $notification->message_en }}</p>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'الحالة:') !!}
    <p>{{ $notification->status == 1 ? 'مقروء' : 'غير مقروء' }}</p>
</div>
