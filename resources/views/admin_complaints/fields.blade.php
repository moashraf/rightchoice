<!-- User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'المستخدم:') !!} <span class="text-danger">*</span>
     <small class="text-danger">{{ $errors->first('user_id') }}</small>
    @if(isset($complaints) && $complaints->userinfo)
        <div class="mt-1">
            <a href="{{ route('sitemanagement.users.index', ['filter_user_id' => $complaints->userinfo->id]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-user ml-1"></i> عرض المستخدم: {{ $complaints->userinfo->name }}
            </a>
        </div>
    @endif
</div>

<!-- Aqar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('aqars_id', 'العقار:') !!} <span class="text-danger">*</span>
     <small class="text-danger">{{ $errors->first('aqars_id') }}</small>
    @if(isset($complaints) && $complaints->aqarinfo)
        <div class="mt-1">
            <a href="{{ route('sitemanagement.aqars.index', ['key_word' => $complaints->aqarinfo->ref_code ?: $complaints->aqarinfo->title]) }}" target="_blank" class="btn btn-sm btn-outline-info">
                <i class="fas fa-home ml-1"></i> عرض العقار: {{ \Illuminate\Support\Str::limit($complaints->aqarinfo->title, 40) }}
            </a>
        </div>
    @endif
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
