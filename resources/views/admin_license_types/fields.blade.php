<!-- License Type (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('license_type', 'License Type (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('license_type', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('license_type') }}</small>
</div>

<!-- License Type (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('license_type_en', 'License Type (English):') !!}
    {!! Form::text('license_type_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('license_type_en') }}</small>
</div>

<div class="clearfix"></div>
