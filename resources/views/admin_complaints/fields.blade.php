<!-- User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'المستخدم:') !!} <span class="text-danger">*</span>
    {!! Form::select('user_id', $users, null, ['placeholder' => 'اختر مستخدماً...', 'class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('user_id') }}</small>
</div>

<!-- Aqar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('aqars_id', 'العقار:') !!} <span class="text-danger">*</span>
    {!! Form::select('aqars_id', $aqars, null, ['placeholder' => 'اختر العقار...', 'class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('aqars_id') }}</small>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'الحالة:') !!}
    {!! Form::select('status', [
        \App\Models\Complaints::COMPLAINT_PENDING    => 'متوقف',
        \App\Models\Complaints::COMPLAINT_INPROGRESS => 'جاري العمل عليه',
        \App\Models\Complaints::COMPLAINT_SOLVED     => 'تم الحل',
    ], null, ['placeholder' => 'اختر الحالة...', 'class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('status') }}</small>
</div>

<!-- Message Field -->
<div class="form-group col-sm-12">
    {!! Form::label('message', 'الرسالة:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 4]) !!}
    <small class="text-danger">{{ $errors->first('message') }}</small>
</div>

<div class="clearfix"></div>
