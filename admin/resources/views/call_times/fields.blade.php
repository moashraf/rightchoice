<!-- Call Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('call_time', 'Call Time:') !!} <span class="text-danger">*</span>
    {!! Form::text('call_time', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('call_time') }}</small>
</div>