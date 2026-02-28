<!-- Finish Type (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finish_type', 'Finish Type (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('finish_type', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('finish_type') }}</small>
</div>

<!-- Finish Type (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finish_type_en', 'Finish Type (English):') !!}
    {!! Form::text('finish_type_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('finish_type_en') }}</small>
</div>

<div class="clearfix"></div>
