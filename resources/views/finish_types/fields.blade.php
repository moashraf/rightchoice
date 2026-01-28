<!-- Finish Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finish_type', 'Finish Type:') !!} <span class="text-danger">*</span>
    {!! Form::text('finish_type', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('finish_type') }}</small>
</div>