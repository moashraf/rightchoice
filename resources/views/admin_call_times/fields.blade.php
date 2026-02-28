<!-- Call Time (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('call_time', 'Call Time (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('call_time', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('call_time') }}</small>
</div>

<!-- Call Time (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('call_time_en', 'Call Time (English):') !!}
    {!! Form::text('call_time_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('call_time_en') }}</small>
</div>

<div class="clearfix"></div>
