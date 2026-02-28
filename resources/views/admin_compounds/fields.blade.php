<!-- Compound (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('compound', 'Compound (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('compound', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('compound') }}</small>
</div>

<!-- Compound (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('compound_en', 'Compound (English):') !!}
    {!! Form::text('compound_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('compound_en') }}</small>
</div>

<div class="clearfix"></div>
