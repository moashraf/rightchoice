<!-- License Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('license_type', 'License Type:') !!} <span class="text-danger">*</span>
    {!! Form::text('license_type', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('license_type') }}</small>
</div>